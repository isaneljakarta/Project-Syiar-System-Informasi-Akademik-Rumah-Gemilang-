<?php

namespace App\Controllers;

use App\Models\StudentModel;

class Instruktur extends BaseController
{
    public function index()
    {
        $studentModel = new StudentModel();

        $data = [
            'title'              => 'Dashboard Instruktur',
            'total_siswa'        => $studentModel->countAll(),
            'total_mapel'        => $studentModel->getJumlahMataPelajaran(),
            'rata_rata'          => $studentModel->getRataRataNilai(),
            'rata_kehadiran'     => $studentModel->getRataRataKehadiran(),
            'persentase_jurusan' => $studentModel->getPersentaseJurusan(),
            'top_students'       => $studentModel->getTopStudents()
        ];

        return view('instruktur/dashboard', $data);
    }

    public function kelas()
    {
        $studentModel = new StudentModel();

        $data = [
            'title'          => 'Pemisah & Analisis Nilai per Kelas',
            'total_siswa'    => $studentModel->countAll(),
            'total_kelas'    => 6,
            'rata_rata'      => $studentModel->getRataRataNilai(),
            'rata_kehadiran' => $studentModel->getRataRataKehadiran(),
            'kelas_stats'    => $studentModel->getClassStatsDetailed(),
            'mapel_stats'    => $studentModel->getMapelStatsDetailed(),
            'data_siswa'     => $studentModel->getAllStudents(),
        ];

        return view('instruktur/kelas', $data);
    }

    public function nilai()
    {
        $studentModel = new StudentModel();

        $data = [
            'title'          => 'Input & Update Nilai Santri',
            'total_siswa'    => $studentModel->countAll(),
            'data_siswa'     => $studentModel->getAllStudents(),
            'rata_rata'      => $studentModel->getRataRataNilai(),
            'total_mapel'    => $studentModel->getJumlahMataPelajaran(),
        ];

        return view('instruktur/nilai', $data);
    }

    public function updateNilai()
    {
        $studentModel = new StudentModel();
        $id = (int)$this->request->getPost('id');

        $student = $studentModel->find($id);
        if (!$student) {
            return redirect()->to('/instruktur/nilai')->with('notif_type', 'delete')
                ->with('notif_title', 'Santri Tidak Ditemukan')
                ->with('notif_msg', "Data santri dengan ID {$id} tidak ada.");
        }

        $tauhid          = (float)$this->request->getPost('tauhid');
        $fiqih           = (float)$this->request->getPost('fiqih');
        $b_ing           = (float)$this->request->getPost('b_ing');
        $menulis_kreatif = (float)$this->request->getPost('menulis_kreatif');
        $adab_akhlaq     = (float)$this->request->getPost('adab_akhlaq');

        $dataToUpdate = [
            'tauhid'          => $tauhid,
            'fiqih'           => $fiqih,
            'b_ing'           => $b_ing,
            'menulis_kreatif' => $menulis_kreatif,
            'adab_akhlaq'     => $adab_akhlaq,
        ];

        $studentModel->update($id, $dataToUpdate);

        return redirect()->to('/instruktur/nilai')
            ->with('notif_type', 'edit')
            ->with('notif_title', 'Nilai Berhasil Diperbarui!')
            ->with('notif_msg', "Nilai akademik & adab untuk {$student['nama']} telah berhasil diupdate.");
    }

    public function kehadiran()
    {
        $studentModel = new StudentModel();

        $data = [
            'title'                 => 'Presensi & Kehadiran Santri',
            'total_siswa'           => $studentModel->countAll(),
            'rata_kehadiran'        => $studentModel->getRataRataKehadiran(),
            'sesi_kehadiran'        => $studentModel->getSesiKehadiran(),
            'rekap_kehadiran_kelas' => $studentModel->getRekapKehadiranPerKelas(),
            'data_siswa'            => $studentModel->getAllStudents(),
            'presensi_terbaru'      => $studentModel->getLatestPresensiPerSantri(),
            'rekap_bulanan'         => $studentModel->getRekapBulananSantri(),
            'all_logs'              => $studentModel->getAllPresensiLogs(),
        ];

        return view('instruktur/kehadiran', $data);
    }

    public function catatPresensi()
    {
        $studentModel = new StudentModel();

        $santriId   = (int)$this->request->getPost('santri_id');
        $sesiId     = (int)$this->request->getPost('sesi_id');
        $status     = $this->request->getPost('status'); // Hadir, Telat, Sakit, Absen
        $tanggal    = $this->request->getPost('tanggal') ?: date('Y-m-d');
        $keterangan = $this->request->getPost('keterangan') ?: '';

        if (!$santriId || !$sesiId || !$status) {
            return redirect()->to('/instruktur/kehadiran')->with('notif_type', 'delete')
                ->with('notif_title', 'Gagal Mencatat Presensi')
                ->with('notif_msg', 'Pilih santri, sesi pertemuan, dan status presensi dengan lengkap.');
        }

        $res = $studentModel->catatPresensi($santriId, $sesiId, $status, $tanggal, $keterangan);

        return redirect()->to('/instruktur/kehadiran')->with('notif_type', 'add')
            ->with('notif_title', "Presensi {$status} Tersimpan!")
            ->with('notif_msg', "Status presensi '{$status}' telah dicatat untuk santri {$res['santri_nama']} pada sesi {$res['sesi_nama']}.");
    }

    // =========================================================================
    // FITUR EKSPOR / DOWNLOAD REKAPAN NILAI & ABSENSI BULANAN SANTRI (CSV)
    // =========================================================================

    /**
     * Download Rekapan Nilai Akademik & Adab Santri dalam format CSV
     */
    public function downloadRekapNilaiCsv()
    {
        $studentModel = new StudentModel();
        $students = $studentModel->getAllStudents();

        $filename = 'Rekap_Nilai_Santri_Syiar_Gemilang_' . date('Ymd_His') . '.csv';

        // Set Native Headers HTTP untuk Download File CSV
        if (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        // Tulis BOM UTF-8 agar Microsoft Excel mengenali encoding karakter dengan tepat
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Header Kolom CSV
        fputcsv($output, [
            'No',
            'Nomor Induk Santri (NIS)',
            'Nama Santri',
            'Kelas Kejuruan',
            'Kampus Cabang',
            'Angkatan',
            'Nilai Tauhid',
            'Nilai Fiqih',
            'Nilai B. Inggris',
            'Nilai Menulis Kreatif',
            'Rata-Rata Akademik',
            'Nilai Adab & Akhlaq',
            'Nilai Akhir Terbobot (80% Akad + 20% Adab)',
            'Persentase Kehadiran (%)',
            'Status Santri'
        ]);

        $no = 1;
        foreach ($students as $s) {
            fputcsv($output, [
                $no++,
                $s['nis'] ?: '-',
                $s['nama'],
                $s['kelas'],
                $s['cabang'] ?: 'Kampus Utama Depok',
                $s['angkatan'] ?: 'Angkatan 35',
                $s['tauhid'],
                $s['fiqih'],
                $s['b_ing'],
                $s['menulis_kreatif'],
                number_format((float)($s['rata_akademik'] ?? 0), 2),
                $s['adab_akhlaq'],
                number_format((float)($s['rata_rata'] ?? 0), 2),
                $s['kehadiran'] . '%',
                $s['status'] ?: 'Aktif'
            ]);
        }

        fclose($output);
        exit;
    }

    /**
     * Download Rekapan Presensi & Kehadiran Bulanan Santri dalam format CSV
     */
    public function downloadRekapAbsensiCsv()
    {
        $studentModel = new StudentModel();
        $students     = $studentModel->getAllStudents();
        $rekapBulanan = $studentModel->getRekapBulananSantri();

        $filename = 'Rekap_Presensi_Bulanan_Santri_' . date('Ymd_His') . '.csv';

        // Set Native Headers HTTP untuk Download File CSV
        if (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        // Tulis BOM UTF-8
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Header Kolom CSV
        fputcsv($output, [
            'No',
            'Nomor Induk Santri (NIS)',
            'Nama Santri',
            'Kelas Kejuruan',
            'Kampus Cabang',
            'Total Sesi Pertemuan',
            'Hadir Tepat Waktu',
            'Terlambat',
            'Izin / Sakit',
            'Absen (Alpa)',
            'Persentase Kehadiran (%)',
            'Status Evaluasi Kedisiplinan'
        ]);

        $no = 1;
        foreach ($students as $s) {
            $santriId = (int)$s['id'];
            $rekap = $rekapBulanan[$santriId] ?? [
                'total_sesi'  => 0,
                'count_hadir' => 0,
                'count_telat' => 0,
                'count_sakit' => 0,
                'count_absen' => 0,
            ];

            $absenCount = (int)($rekap['count_absen'] ?? 0);
            $statusDisiplin = 'Disiplin Baik';
            if ($absenCount > 3) {
                $statusDisiplin = 'PERINGATAN: Absen > 3x (Harap Evaluasi)';
            } elseif ($absenCount > 0) {
                $statusDisiplin = 'Perhatian: Ada Absen';
            }

            fputcsv($output, [
                $no++,
                $s['nis'] ?: '-',
                $s['nama'],
                $s['kelas'],
                $s['cabang'] ?: 'Kampus Utama Depok',
                $rekap['total_sesi'] ?? 0,
                $rekap['count_hadir'] ?? 0,
                $rekap['count_telat'] ?? 0,
                $rekap['count_sakit'] ?? 0,
                $absenCount,
                $s['kehadiran'] . '%',
                $statusDisiplin
            ]);
        }

        fclose($output);
        exit;
    }
}

