<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $primaryKey    = 'id';
    protected $table         = 'nilai_santri'; // Nama tabel di database
    protected $allowedFields = ['nama', 'kelas', 'tauhid', 'fiqih', 'b_ing', 'menulis_kreatif', 'adab_akhlaq', 'kehadiran']; // Kolom yang diizinkan untuk diisi

    // Kolom perhitungan nilai dengan pembobotan 80% Akademik + 20% Adab & Akhlaq
    private string $selectFormula = 'id, nama, kelas, tauhid, b_ing, menulis_kreatif, fiqih, adab_akhlaq, kehadiran,
        ROUND((tauhid + b_ing + menulis_kreatif + fiqih) / 4, 2) as rata_akademik,
        ROUND((((tauhid + b_ing + menulis_kreatif + fiqih) / 4 * 0.8) + (adab_akhlaq * 0.2)), 2) as rata_rata';

    /**
     * Mengambil 5 Santri dengan Nilai Akhir Tertinggi (Termasuk 20% Adab & Akhlaq)
     */
    public function getTopStudents()
    {
        return $this->select($this->selectFormula)
            ->orderBy('rata_rata', 'DESC')
            ->orderBy('nama', 'ASC')
            ->findAll(5);
    }

    /**
     * Mengambil Semua Data Santri Lengkap dengan Nilai Rata-rata Terbobot dan Kehadiran
     */
    public function getAllStudents()
    {
        return $this->select($this->selectFormula)
            ->orderBy('id', 'ASC')
            ->findAll();
    }

    /**
     * Menghitung Rata-rata Nilai Keseluruhan (80% Akademik + 20% Adab & Akhlaq)
     */
    public function getRataRataNilai()
    {
        $query = $this->selectAvg('(((tauhid + b_ing + menulis_kreatif + fiqih) / 4 * 0.8) + (adab_akhlaq * 0.2))', 'total_avg')->get();
        $result = $query->getRowArray();

        return round((float)($result['total_avg'] ?? 0), 2);
    }

    /**
     * Menghitung Rata-rata Kehadiran Keseluruhan Santri (%)
     */
    public function getRataRataKehadiran()
    {
        $query = $this->selectAvg('kehadiran', 'avg_kehadiran')->get();
        $result = $query->getRowArray();

        return round((float)($result['avg_kehadiran'] ?? 95), 1);
    }

    /**
     * Mengambil Jumlah Aspek Penilaian / Mapel (Tauhid, Fiqih, B.Inggris, Menulis Kreatif, Adab & Akhlaq)
     */
    public function getJumlahMataPelajaran()
    {
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('nilai_santri');

        // Kolom yang BUKAN merupakan mata pelajaran / aspek penilaian
        $kolom_bukan_mapel = ['id', 'nama', 'kelas', 'nilai_global', 'kehadiran'];

        $mapel = array_diff($fields, $kolom_bukan_mapel);
        return count($mapel);
    }

    /**
     * Mengambil Distribusi dan Persentase Jumlah Santri per Jurusan / Kelas
     */
    public function getPersentaseJurusan()
    {
        $totalSantri = $this->countAll() ?: 1;
        $db = \Config\Database::connect();
        $rows = $db->table($this->table)
                   ->select('kelas, COUNT(*) as total_santri, ROUND(AVG(kehadiran), 1) as avg_kehadiran')
                   ->groupBy('kelas')
                   ->orderBy('total_santri', 'DESC')
                   ->orderBy('kelas', 'ASC')
                   ->get()
                   ->getResultArray();

        foreach ($rows as &$r) {
            $r['persentase'] = round(($r['total_santri'] / $totalSantri) * 100, 1);
        }
        unset($r);

        return $rows;
    }

    /**
     * Mengambil Semua Ranking Santri Diurutkan dari Nilai Terbobot Tertinggi
     */
    public function getAllRanking()
    {
        return $this->select($this->selectFormula)
            ->orderBy('rata_rata', 'DESC')
            ->orderBy('nama', 'ASC')
            ->findAll();
    }

    /**
     * Mengambil 3 Siswa Terbaik per Jurusan/Kelas (80% Akademik + 20% Adab & Akhlaq)
     */
    public function getTop3PerClass()
    {
        $all = $this->select($this->selectFormula)
            ->orderBy('kelas', 'ASC')
            ->orderBy('rata_rata', 'DESC')
            ->orderBy('nama', 'ASC')
            ->findAll();

        $topPerClass = [];
        foreach ($all as $student) {
            $kelas = $student['kelas'];
            if (!isset($topPerClass[$kelas])) {
                $topPerClass[$kelas] = [];
            }
            if (count($topPerClass[$kelas]) < 3) {
                $student['rank'] = count($topPerClass[$kelas]) + 1;
                $topPerClass[$kelas][] = $student;
            }
        }

        return $topPerClass;
    }

    /**
     * Mengambil Data Rekap Kehadiran per Jurusan / Kelas
     */
    public function getRekapKehadiranPerKelas()
    {
        $db = \Config\Database::connect();
        return $db->table($this->table)
                  ->select('kelas, COUNT(*) as total_santri, ROUND(AVG(kehadiran), 1) as avg_kehadiran, MIN(kehadiran) as min_kehadiran, MAX(kehadiran) as max_kehadiran')
                  ->groupBy('kelas')
                  ->orderBy('avg_kehadiran', 'DESC')
                  ->get()
                  ->getResultArray();
    }

    /**
     * Mengambil Daftar Sesi Kehadiran Pertemuan
     */
    public function getSesiKehadiran()
    {
        $db = \Config\Database::connect();
        return $db->table('sesi_kehadiran')
                  ->orderBy('tanggal', 'DESC')
                  ->orderBy('id', 'DESC')
                  ->get()
                  ->getResultArray();
    }

    /**
     * Mencatat / memperbarui presensi kehadiran santri pada suatu sesi
     */
    public function catatPresensi(int $santriId, int $sesiId, string $status, string $tanggal, string $keterangan = '')
    {
        $db = \Config\Database::connect();

        // 1. Ambil data santri dan sesi
        $santri = $this->find($santriId);
        $sesi = $db->table('sesi_kehadiran')->where('id', $sesiId)->get()->getRowArray();

        $santriNama = $santri['nama'] ?? 'Santri #' . $santriId;
        $sesiNama   = $sesi['nama_sesi'] ?? 'Sesi #' . $sesiId;

        // 2. Cek apakah log sudah ada untuk santri & sesi ini
        $existing = $db->table('presensi_log')
                       ->where('santri_id', $santriId)
                       ->where('sesi_id', $sesiId)
                       ->get()
                       ->getRowArray();

        if ($existing) {
            $db->table('presensi_log')->where('id', $existing['id'])->update([
                'status'     => $status,
                'tanggal'    => $tanggal,
                'keterangan' => $keterangan,
            ]);
        } else {
            $db->table('presensi_log')->insert([
                'santri_id'  => $santriId,
                'sesi_id'    => $sesiId,
                'status'     => $status,
                'tanggal'    => $tanggal,
                'keterangan' => $keterangan,
            ]);
        }

        // 3. Update counter total pada sesi_kehadiran
        $counts = $db->table('presensi_log')
                     ->select('status, COUNT(*) as c')
                     ->where('sesi_id', $sesiId)
                     ->groupBy('status')
                     ->get()
                     ->getResultArray();

        $totHadir = 0; $totTelat = 0; $totSakit = 0; $totAlpa = 0;
        foreach ($counts as $cnt) {
            if ($cnt['status'] === 'Hadir') $totHadir = (int)$cnt['c'];
            elseif ($cnt['status'] === 'Telat') $totTelat = (int)$cnt['c'];
            elseif ($cnt['status'] === 'Sakit') $totSakit = (int)$cnt['c'];
            elseif ($cnt['status'] === 'Absen') $totAlpa = (int)$cnt['c'];
        }

        $db->table('sesi_kehadiran')->where('id', $sesiId)->update([
            'total_hadir' => $totHadir,
            'total_telat' => $totTelat,
            'total_sakit' => $totSakit,
            'total_alpa'  => $totAlpa,
        ]);

        // 4. Hitung penyesuaian persentase kehadiran santri
        $curKehadiran = (int)($santri['kehadiran'] ?? 95);
        if ($status === 'Hadir') {
            $curKehadiran = min(100, $curKehadiran + 1);
        } elseif ($status === 'Telat') {
            $curKehadiran = max(80, $curKehadiran - 1);
        } elseif ($status === 'Sakit') {
            $curKehadiran = max(75, $curKehadiran - 2);
        } elseif ($status === 'Absen') {
            $curKehadiran = max(60, $curKehadiran - 4);
        }

        $this->update($santriId, ['kehadiran' => $curKehadiran]);

        return [
            'santri_nama' => $santriNama,
            'sesi_nama'   => $sesiNama,
            'status'      => $status,
            'kehadiran'   => $curKehadiran
        ];
    }

    /**
     * Mengambil Log Presensi Terbaru per Santri
     */
    public function getLatestPresensiPerSantri()
    {
        $db = \Config\Database::connect();
        $rows = $db->table('presensi_log p')
                   ->select('p.santri_id, p.sesi_id, p.status, p.tanggal, p.keterangan, s.nama_sesi, s.waktu')
                   ->join('sesi_kehadiran s', 's.id = p.sesi_id', 'left')
                   ->orderBy('p.id', 'DESC')
                   ->get()
                   ->getResultArray();

        $map = [];
        foreach ($rows as $r) {
            $sId = $r['santri_id'];
            if (!isset($map[$sId])) {
                $map[$sId] = $r;
            }
        }
        return $map;
    }

    /**
     * Mengambil Rekapitulasi Presensi Selama 1 Bulan per Santri
     */
    public function getRekapBulananSantri()
    {
        $db = \Config\Database::connect();
        $rows = $db->table('presensi_log')
                   ->select('santri_id, COUNT(*) as total_sesi,
                             SUM(CASE WHEN status = "Hadir" THEN 1 ELSE 0 END) as count_hadir,
                             SUM(CASE WHEN status = "Telat" THEN 1 ELSE 0 END) as count_telat,
                             SUM(CASE WHEN status = "Sakit" THEN 1 ELSE 0 END) as count_sakit,
                             SUM(CASE WHEN status = "Absen" THEN 1 ELSE 0 END) as count_absen')
                   ->groupBy('santri_id')
                   ->get()
                   ->getResultArray();

        $map = [];
        foreach ($rows as $r) {
            $map[$r['santri_id']] = $r;
        }
        return $map;
    }

    /**
     * Mengambil Seluruh Log Presensi Selama 1 Bulan Terakhir
     */
    public function getAllPresensiLogs()
    {
        $db = \Config\Database::connect();
        return $db->table('presensi_log p')
                  ->select('p.id, p.santri_id, p.sesi_id, p.status, p.tanggal, p.keterangan, s.nama_sesi, s.waktu, s.lokasi')
                  ->join('sesi_kehadiran s', 's.id = p.sesi_id', 'left')
                  ->orderBy('p.tanggal', 'DESC')
                  ->orderBy('p.id', 'DESC')
                  ->get()
                  ->getResultArray();
    }

    /**
     * Mengambil Data Statistik Terpisah per Kelas (Untuk Page Pemisah Nilai Kelas Instruktur)
     */
    public function getClassStatsDetailed()
    {
        $db = \Config\Database::connect();
        $rows = $db->table($this->table)
            ->select('kelas, COUNT(*) as total_santri,
                      ROUND(AVG(tauhid), 1) as avg_tauhid,
                      ROUND(AVG(fiqih), 1) as avg_fiqih,
                      ROUND(AVG(b_ing), 1) as avg_bing,
                      ROUND(AVG(menulis_kreatif), 1) as avg_menulis,
                      ROUND(AVG(adab_akhlaq), 1) as avg_adab,
                      ROUND(AVG((tauhid + fiqih + b_ing + menulis_kreatif) / 4), 2) as avg_akademik,
                      ROUND(AVG(((tauhid + fiqih + b_ing + menulis_kreatif) / 4 * 0.8) + (adab_akhlaq * 0.2)), 2) as avg_akhir,
                      ROUND(AVG(kehadiran), 1) as avg_kehadiran,
                      MAX(((tauhid + fiqih + b_ing + menulis_kreatif) / 4 * 0.8) + (adab_akhlaq * 0.2)) as max_akhir,
                      MIN(((tauhid + fiqih + b_ing + menulis_kreatif) / 4 * 0.8) + (adab_akhlaq * 0.2)) as min_akhir')
            ->groupBy('kelas')
            ->orderBy('kelas', 'ASC')
            ->get()
            ->getResultArray();

        $meta = [
            'Teknik Komputer dan Jaringan' => [
                'code'       => 'TKJ',
                'short_name' => 'TKJ',
                'color'      => 'emerald',
                'badge_bg'   => 'bg-emerald-600',
                'text_color' => 'text-emerald-600',
                'light_bg'   => 'bg-emerald-50',
                'border_col' => 'border-emerald-200',
                'icon'       => 'fa-network-wired',
                'cover'      => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=700&q=80',
                'desc'       => 'Fokus pada routing MikroTik, konfigurasi Linux Server, keamanan jaringan & instalasi serat optik.',
                'wali_kelas' => 'Budi Santoso, S.T.'
            ],
            'Tata Busana' => [
                'code'       => 'TB',
                'short_name' => 'Tata Busana',
                'color'      => 'yellow',
                'badge_bg'   => 'bg-yellow-500',
                'text_color' => 'text-yellow-700',
                'light_bg'   => 'bg-yellow-50',
                'border_col' => 'border-yellow-200',
                'icon'       => 'fa-scissors',
                'cover'      => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=700&q=80',
                'desc'       => 'Penguasaan konstruksi pola, menjahit busana muslimah siap pakai, bordir & kewirausahaan garmen.',
                'wali_kelas' => 'Nur Halimah, S.Pd.'
            ],
            'Fotografi dan Videografi' => [
                'code'       => 'FV',
                'short_name' => 'Fotografi & Video',
                'color'      => 'blue',
                'badge_bg'   => 'bg-blue-600',
                'text_color' => 'text-blue-600',
                'light_bg'   => 'bg-blue-50',
                'border_col' => 'border-blue-200',
                'icon'       => 'fa-camera',
                'cover'      => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=700&q=80',
                'desc'       => 'Keahlian sinematografi, teknik pencahayaan studio, editing video profesional & visual branding.',
                'wali_kelas' => 'Rian Hidayat, S.Sn.'
            ],
            'Desain Grafis' => [
                'code'       => 'DG',
                'short_name' => 'Desain Grafis',
                'color'      => 'red',
                'badge_bg'   => 'bg-red-600',
                'text_color' => 'text-red-600',
                'light_bg'   => 'bg-red-50',
                'border_col' => 'border-red-200',
                'icon'       => 'fa-pen-nib',
                'cover'      => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=700&q=80',
                'desc'       => 'Eksplorasi identitas visual, Adobe Creative Suite, UI/UX interface & desain kemasan komersial.',
                'wali_kelas' => 'Siti Rahmawati, S.Ds.'
            ],
            'Otomotif' => [
                'code'       => 'OTO',
                'short_name' => 'Otomotif',
                'color'      => 'slate',
                'badge_bg'   => 'bg-slate-900',
                'text_color' => 'text-slate-900',
                'light_bg'   => 'bg-slate-100',
                'border_col' => 'border-slate-300',
                'icon'       => 'fa-wrench',
                'cover'      => 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?auto=format&fit=crop&w=700&q=80',
                'desc'       => 'Pemeliharaan mesin motor & mobil, sistem kelistrikan kendaraan, diagnosis injeksi & servis terpadu.',
                'wali_kelas' => 'Hendra Setiawan, S.T.'
            ],
            'Aplikasi Perkantoran' => [
                'code'       => 'AP',
                'short_name' => 'Perkantoran',
                'color'      => 'orange',
                'badge_bg'   => 'bg-orange-500',
                'text_color' => 'text-orange-600',
                'light_bg'   => 'bg-orange-50',
                'border_col' => 'border-orange-200',
                'icon'       => 'fa-file-excel',
                'cover'      => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=700&q=80',
                'desc'       => 'Penguasaan formula spreadsheet lanjutan, otomasi berkas perkantoran, dan korespondensi bisnis digital.',
                'wali_kelas' => 'Dedi Kurniawan, S.Kom.'
            ],
        ];

        foreach ($rows as &$r) {
            $k = $r['kelas'];
            $info = $meta[$k] ?? [
                'code'       => strtoupper(substr($k, 0, 3)),
                'short_name' => $k,
                'color'      => 'blue',
                'badge_bg'   => 'bg-blue-600',
                'text_color' => 'text-blue-600',
                'light_bg'   => 'bg-blue-50',
                'border_col' => 'border-blue-200',
                'icon'       => 'fa-graduation-cap',
                'cover'      => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=700&q=80',
                'desc'       => 'Kelas kejuruan terpadu Rumah Gemilang Indonesia.',
                'wali_kelas' => 'Instruktur Pengampu'
            ];
            $r = array_merge($r, $info);
        }
        unset($r);

        return $rows;
    }

    /**
     * Mengambil Data Statistik untuk 4 Mata Pelajaran Utama + Adab & Akhlaq
     */
    public function getMapelStatsDetailed()
    {
        $db = \Config\Database::connect();
        $total = $this->countAll() ?: 1;

        $calc = $db->table($this->table)->select('
            ROUND(AVG(tauhid), 1) as avg_tauhid, MAX(tauhid) as max_tauhid, MIN(tauhid) as min_tauhid,
            SUM(CASE WHEN tauhid >= 75 THEN 1 ELSE 0 END) as pass_tauhid,
            ROUND(AVG(fiqih), 1) as avg_fiqih, MAX(fiqih) as max_fiqih, MIN(fiqih) as min_fiqih,
            SUM(CASE WHEN fiqih >= 75 THEN 1 ELSE 0 END) as pass_fiqih,
            ROUND(AVG(b_ing), 1) as avg_bing, MAX(b_ing) as max_bing, MIN(b_ing) as min_bing,
            SUM(CASE WHEN b_ing >= 75 THEN 1 ELSE 0 END) as pass_bing,
            ROUND(AVG(menulis_kreatif), 1) as avg_menulis, MAX(menulis_kreatif) as max_menulis, MIN(menulis_kreatif) as min_menulis,
            SUM(CASE WHEN menulis_kreatif >= 75 THEN 1 ELSE 0 END) as pass_menulis,
            ROUND(AVG(adab_akhlaq), 1) as avg_adab, MAX(adab_akhlaq) as max_adab, MIN(adab_akhlaq) as min_adab,
            SUM(CASE WHEN adab_akhlaq >= 80 THEN 1 ELSE 0 END) as pass_adab
        ')->get()->getRowArray();

        return [
            'tauhid' => [
                'id'          => 'mapel-tauhid',
                'key'         => 'tauhid',
                'nama'        => 'Tauhid & Aqidah Islamiyah',
                'short'       => 'Tauhid',
                'pengampu'    => 'Ustadz Kamal Malawi',
                'gelar'       => 'Pengampu Aqidah & Kepesantrenan',
                'nip'         => 'INS-SG-01',
                'avatar'      => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=260&q=80',
                'cover'       => 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?auto=format&fit=crop&w=700&q=80',
                'badge_color' => 'bg-emerald-600 text-white',
                'badge_soft'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'icon'        => 'fa-book-quran',
                'kkm'         => 75,
                'rata_rata'   => (float)($calc['avg_tauhid'] ?? 85.0),
                'tertinggi'   => (int)($calc['max_tauhid'] ?? 98),
                'terendah'    => (int)($calc['min_tauhid'] ?? 70),
                'kelulusan'   => round((((int)($calc['pass_tauhid'] ?? $total)) / $total) * 100, 1),
                'total_lulus' => (int)($calc['pass_tauhid'] ?? $total),
                'jadwal'      => 'Senin (07:00 - 09:00 WIB)',
                'ruang'       => 'Aula Serbaguna RGI',
                'bobot'       => 'Akademik Terpadu',
                'tags'        => ['Rukun Iman', 'Tauhid Uluhiyah', 'Asmaul Husna', 'Aqidah Shahihah'],
                'deskripsi'   => 'Menanamkan pondasi aqidah yang lurus, pemahaman tauhid aplikatif, serta pembentukan integritas keimanan dalam keseharian santri kejuruan.'
            ],
            'fiqih' => [
                'id'          => 'mapel-fiqih',
                'key'         => 'fiqih',
                'nama'        => 'Fiqih Ibadah & Muamalah',
                'short'       => 'Fiqih',
                'pengampu'    => 'Ustadzah Yanni Susanti',
                'gelar'       => 'Pengampu Syariah & Ibadah Praktis',
                'nip'         => 'INS-SG-02',
                'avatar'      => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=260&q=80',
                'cover'       => 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?auto=format&fit=crop&w=700&q=80',
                'badge_color' => 'bg-sky-600 text-white',
                'badge_soft'  => 'bg-sky-50 text-sky-700 border-sky-200',
                'icon'        => 'fa-hands-praying',
                'kkm'         => 75,
                'rata_rata'   => (float)($calc['avg_fiqih'] ?? 86.0),
                'tertinggi'   => (int)($calc['max_fiqih'] ?? 98),
                'terendah'    => (int)($calc['min_fiqih'] ?? 72),
                'kelulusan'   => round((((int)($calc['pass_fiqih'] ?? $total)) / $total) * 100, 1),
                'total_lulus' => (int)($calc['pass_fiqih'] ?? $total),
                'jadwal'      => 'Selasa (07:00 - 09:00 WIB)',
                'ruang'       => 'Aula Serbaguna RGI',
                'bobot'       => 'Akademik Terpadu',
                'tags'        => ['Thaharah', 'Shalat Khusyu', 'Zakat & Wakaf', 'Muamalah Modern'],
                'deskripsi'   => 'Membekali santri pemahaman hukum ibadah amaliyah harian, adab bersuci, fiqih muamalah kontemporer, dan panduan syar\'i dalam perniagaan.'
            ],
            'b_ing' => [
                'id'          => 'mapel-bing',
                'key'         => 'b_ing',
                'nama'        => 'Bahasa Inggris Komunikasi & Profesi',
                'short'       => 'B. Inggris',
                'pengampu'    => 'Mr. Alex Chandra, M.Hum.',
                'gelar'       => 'Instruktur English for Specific Purpose',
                'nip'         => 'INS-SG-03',
                'avatar'      => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=260&q=80',
                'cover'       => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?auto=format&fit=crop&w=700&q=80',
                'badge_color' => 'bg-indigo-600 text-white',
                'badge_soft'  => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                'icon'        => 'fa-language',
                'kkm'         => 75,
                'rata_rata'   => (float)($calc['avg_bing'] ?? 84.0),
                'tertinggi'   => (int)($calc['max_bing'] ?? 97),
                'terendah'    => (int)($calc['min_bing'] ?? 68),
                'kelulusan'   => round((((int)($calc['pass_bing'] ?? $total)) / $total) * 100, 1),
                'total_lulus' => (int)($calc['pass_bing'] ?? $total),
                'jadwal'      => 'Rabu (10:00 - 12:00 WIB)',
                'ruang'       => 'Lab Bahasa Multimedia',
                'bobot'       => 'Akademik Terpadu',
                'tags'        => ['Speaking Skill', 'Technical Vocab', 'Job Interview', 'Email Writing'],
                'deskripsi'   => 'Melatih kelancaran berkomunikasi dalam bahasa Inggris praktis, penguasaan istilah teknis kejuruan, dan kesiapan komunikasi dunia kerja global.'
            ],
            'menulis_kreatif' => [
                'id'          => 'mapel-menulis',
                'key'         => 'menulis_kreatif',
                'nama'        => 'Menulis Kreatif & Konten Dakwah',
                'short'       => 'Menulis Kreatif',
                'pengampu'    => 'Ustadz M. Syakir, S.I.Kom.',
                'gelar'       => 'Instruktur Jurnalistik & Storytelling',
                'nip'         => 'INS-SG-04',
                'avatar'      => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=260&q=80',
                'cover'       => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=700&q=80',
                'badge_color' => 'bg-amber-600 text-white',
                'badge_soft'  => 'bg-amber-50 text-amber-700 border-amber-200',
                'icon'        => 'fa-pen-fancy',
                'kkm'         => 75,
                'rata_rata'   => (float)($calc['avg_menulis'] ?? 86.5),
                'tertinggi'   => (int)($calc['max_menulis'] ?? 98),
                'terendah'    => (int)($calc['min_menulis'] ?? 70),
                'kelulusan'   => round((((int)($calc['pass_menulis'] ?? $total)) / $total) * 100, 1),
                'total_lulus' => (int)($calc['pass_menulis'] ?? $total),
                'jadwal'      => 'Kamis (10:00 - 12:00 WIB)',
                'ruang'       => 'Ruang Diskusi Kreatif',
                'bobot'       => 'Akademik Terpadu',
                'tags'        => ['Copywriting', 'Dakwah Storytelling', 'Artikel Opini', 'Media Sosial'],
                'deskripsi'   => 'Mengasah kemampuan menulis narasi memikat, penyusunan copywriting komersial, esai dakwah, dan strategi narasi digital santri.'
            ],
            'adab_akhlaq' => [
                'id'          => 'mapel-adab',
                'key'         => 'adab_akhlaq',
                'nama'        => 'Adab & Akhlaq Santri (Bobot 20%)',
                'short'       => 'Adab & Akhlaq',
                'pengampu'    => 'Dewan Musyrif & Kepengasuhan',
                'gelar'       => 'Tim Pembina Karakter Santri',
                'nip'         => 'MSR-SG-05',
                'avatar'      => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=260&q=80',
                'cover'       => 'https://images.unsplash.com/photo-1519452635265-7b1fbfd1e4e0?auto=format&fit=crop&w=700&q=80',
                'badge_color' => 'bg-rose-600 text-white',
                'badge_soft'  => 'bg-rose-50 text-rose-700 border-rose-200',
                'icon'        => 'fa-heart-circle-check',
                'kkm'         => 80,
                'rata_rata'   => (float)($calc['avg_adab'] ?? 87.5),
                'tertinggi'   => (int)($calc['max_adab'] ?? 99),
                'terendah'    => (int)($calc['min_adab'] ?? 75),
                'kelulusan'   => round((((int)($calc['pass_adab'] ?? $total)) / $total) * 100, 1),
                'total_lulus' => (int)($calc['pass_adab'] ?? $total),
                'jadwal'      => 'Evaluasi Harian & Mingguan',
                'ruang'       => 'Asrama & Masjid RGI',
                'bobot'       => 'Bobot 20% Nilai Akhir',
                'tags'        => ['Birrul Walidain', 'Integritas & Kejujuran', 'Adab Penuntut Ilmu', 'Kedisiplinan'],
                'deskripsi'   => 'Komponen penentu karakter kelulusan. Menilai tata krama kepada asatidz, sesama santri, amanah kejuruan, dan keteladanan akhlaq karimah.'
            ]
        ];
    }
}
