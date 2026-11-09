<?php

namespace App\Controllers;

use App\Models\StudentModel;

class Admin extends BaseController
{
    public function index()
    {
        $studentModel = new StudentModel();

        $data = [
            'title'              => 'Dashboard Akademik & Kejuruan',
            'total_siswa'        => $studentModel->countAll(),
            'total_mapel'        => $studentModel->getJumlahMataPelajaran(),
            'rata_rata'          => $studentModel->getRataRataNilai(),
            'rata_kehadiran'     => $studentModel->getRataRataKehadiran(),
            'persentase_jurusan' => $studentModel->getPersentaseJurusan(),
            'top_students'       => $studentModel->getTopStudents()
        ];

        return view('admin/dashboard', $data);
    }

    public function addStudent()
    {
        $data = [
            'title' => 'Tambah Data Santri'
        ];
        return view('admin/student_add', $data);
    }

    public function saveStudent()
    {
        $studentModel = new StudentModel();

        $name            = trim((string)$this->request->getPost('nama'));
        $class           = $this->request->getPost('kelas');
        $nis             = trim((string)$this->request->getPost('nis'));
        $cabang          = trim((string)$this->request->getPost('cabang')) ?: 'Kampus Utama Depok';
        $angkatan        = trim((string)$this->request->getPost('angkatan')) ?: 'Angkatan 35';
        $status          = $this->request->getPost('status') ?: 'Aktif';
        $tauhid          = $this->request->getPost('tauhid');
        $fiqih           = $this->request->getPost('fiqih');
        $b_ing           = $this->request->getPost('b_ing');
        $menulis_kreatif = $this->request->getPost('menulis_kreatif');
        $adab_akhlaq     = $this->request->getPost('adab_akhlaq') ?: 85;
        $kehadiran       = $this->request->getPost('kehadiran') ?: 95;

        // Validasi sederhana untuk memastikan data wajib tidak kosong
        if (empty($name) || empty($class) || empty($tauhid) || empty($fiqih) || empty($b_ing) || empty($menulis_kreatif)) {
            return redirect()->back()->withInput()->with('error', 'Semua kolom nilai dan nama wajib diisi!');
        }

        // Handle Upload Foto Profil
        $fotoName = null;
        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            if (in_array($fotoFile->getMimeType(), $allowedMimes, true)) {
                $fotoName = $fotoFile->getRandomName();
                $targetDir = FCPATH . 'uploads/santri';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $fotoFile->move($targetDir, $fotoName);
            }
        }

        // Auto-generate NIS bila kosong
        if (empty($nis)) {
            $lastRow = $studentModel->orderBy('id', 'DESC')->first();
            $nextId = ($lastRow ? (int)$lastRow['id'] : 0) + 1;
            $nis = 'RGI-35' . str_pad((string)$nextId, 3, '0', STR_PAD_LEFT);
        }

        $dataToSave = [
            'nama'            => $name,
            'nis'             => $nis,
            'cabang'          => $cabang,
            'kelas'           => $class,
            'angkatan'        => $angkatan,
            'status'          => $status,
            'foto'            => $fotoName,
            'tauhid'          => $tauhid,
            'fiqih'           => $fiqih,
            'b_ing'           => $b_ing,
            'menulis_kreatif' => $menulis_kreatif,
            'adab_akhlaq'     => $adab_akhlaq,
            'kehadiran'       => $kehadiran,
        ];

        $studentModel->insert($dataToSave);

        return redirect()->to(base_url('/admin/data'))->with('notif_type', 'add')
            ->with('notif_title', 'Berhasil Menambahkan Santri!')
            ->with('notif_msg', "Data santri {$name} (NIS: {$nis}) berhasil ditambahkan!");
    }

    public function dataStudent()
    {
        $studentModel = new StudentModel();

        $data = [
            'title'          => 'Data Santri & Akademik',
            'total_siswa'    => $studentModel->countAll(),
            'data_siswa'     => $studentModel->getAllStudents(),
            'rata_rata'      => $studentModel->getRataRataNilai(),
            'rata_kehadiran' => $studentModel->getRataRataKehadiran(),
            'total_mapel'    => $studentModel->getJumlahMataPelajaran(),
            'top_students'   => $studentModel->getTopStudents()
        ];

        return view('admin/data_santri', $data);
    }

    public function update()
    {
        $studentModel = new StudentModel();
        $id = (int)$this->request->getPost('id');

        $dataToUpdate = [
            'nama'            => trim((string)$this->request->getPost('nama')),
            'nis'             => trim((string)$this->request->getPost('nis')),
            'cabang'          => trim((string)$this->request->getPost('cabang')) ?: 'Kampus Utama Depok',
            'kelas'           => $this->request->getPost('kelas'),
            'angkatan'        => trim((string)$this->request->getPost('angkatan')) ?: 'Angkatan 35',
            'status'          => $this->request->getPost('status') ?: 'Aktif',
            'tauhid'          => $this->request->getPost('tauhid'),
            'fiqih'           => $this->request->getPost('fiqih'),
            'b_ing'           => $this->request->getPost('b_ing'),
            'menulis_kreatif' => $this->request->getPost('menulis_kreatif'),
            'adab_akhlaq'     => $this->request->getPost('adab_akhlaq') ?? 85,
            'kehadiran'       => $this->request->getPost('kehadiran') ?? 95,
        ];

        // Handle foto upload jika diunggah file baru
        $fotoFile = $this->request->getFile('foto');
        if ($fotoFile && $fotoFile->isValid() && !$fotoFile->hasMoved()) {
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            if (in_array($fotoFile->getMimeType(), $allowedMimes, true)) {
                $fotoName = $fotoFile->getRandomName();
                $targetDir = FCPATH . 'uploads/santri';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $fotoFile->move($targetDir, $fotoName);
                $dataToUpdate['foto'] = $fotoName;
            }
        }

        $studentModel->update($id, $dataToUpdate);

        return redirect()->to('/admin/data')
            ->with('notif_type', 'edit')
            ->with('notif_title', 'Data Santri Diperbarui!')
            ->with('notif_msg', "Data santri {$dataToUpdate['nama']} (NIS: {$dataToUpdate['nis']}) berhasil diedit.");
    }

    public function delete($id = null)
    {
        $studentModel = new StudentModel();

        $student = $studentModel->find($id);

        if (!$student) {
            return redirect()->to('/admin/data')
                ->with('notif_type', 'delete')
                ->with('notif_title', 'Gagal Menghapus!')
                ->with('notif_msg', "Data santri dengan ID {$id} tidak ditemukan.");
        }

        $deletedName = $student['nama'];
        $studentModel->delete($id);

        return redirect()->to('/admin/data')
            ->with('notif_type', 'delete')
            ->with('notif_title', 'Data Santri Dihapus!')
            ->with('notif_msg', "Data santri {$deletedName} ({$id}) telah dihapus dari daftar.");
    }

    public function pemeringkatan()
    {
        $studentModel = new StudentModel();

        $data = [
            'title'          => 'Pemeringkatan Siswa',
            'total_siswa'    => $studentModel->countAll(),
            'rata_rata'      => $studentModel->getRataRataNilai(),
            'total_mapel'    => $studentModel->getJumlahMataPelajaran(),
            'top3_per_kelas' => $studentModel->getTop3PerClass(),
            'ranking_all'    => $studentModel->getAllRanking()
        ];

        return view('admin/pemeringkatan', $data);
    }

    public function kehadiran()
    {
        $studentModel = new StudentModel();

        $data = [
            'title'                 => 'Sesi & Rekap Kehadiran Santri',
            'total_siswa'           => $studentModel->countAll(),
            'rata_kehadiran'        => $studentModel->getRataRataKehadiran(),
            'sesi_kehadiran'        => $studentModel->getSesiKehadiran(),
            'rekap_kehadiran_kelas' => $studentModel->getRekapKehadiranPerKelas(),
            'data_siswa'            => $studentModel->getAllStudents(),
            'presensi_terbaru'      => $studentModel->getLatestPresensiPerSantri(),
            'rekap_bulanan'         => $studentModel->getRekapBulananSantri(),
            'all_logs'              => $studentModel->getAllPresensiLogs(),
        ];

        return view('admin/kehadiran', $data);
    }

    public function catatPresensiSantri()
    {
        $studentModel = new StudentModel();

        $santriId   = (int)$this->request->getPost('santri_id');
        $sesiId     = (int)$this->request->getPost('sesi_id');
        $status     = $this->request->getPost('status'); // 'Hadir', 'Telat', 'Sakit', 'Absen'
        $tanggal    = $this->request->getPost('tanggal') ?: date('Y-m-d');
        $keterangan = $this->request->getPost('keterangan') ?: '';

        if (!$santriId || !$sesiId || !$status) {
            return redirect()->to('/admin/kehadiran')->with('notif_type', 'delete')
                ->with('notif_title', 'Gagal Mencatat Presensi')
                ->with('notif_msg', 'Santri, sesi kehadiran, dan status presensi wajib dipilih.');
        }

        $res = $studentModel->catatPresensi($santriId, $sesiId, $status, $tanggal, $keterangan);

        return redirect()->to('/admin/kehadiran')->with('notif_type', 'add')
            ->with('notif_title', "Presensi {$status} Berhasil Dicatat!")
            ->with('notif_msg', "Status '{$status}' telah disimpan untuk santri {$res['santri_nama']} pada sesi '{$res['sesi_nama']}'.");
    }

    public function addSesiKehadiran()
    {
        $db = \Config\Database::connect();
        $namaSesi = $this->request->getPost('nama_sesi');
        $tanggal  = $this->request->getPost('tanggal') ?: date('Y-m-d');
        $waktu    = $this->request->getPost('waktu') ?: '07:30 - 11:30';
        $lokasi   = $this->request->getPost('lokasi') ?: 'Ruang Kelas';
        $ket      = $this->request->getPost('keterangan') ?: 'Sesi Pembelajaran';
        $hadir    = (int)($this->request->getPost('total_hadir') ?: 48);
        $telat    = (int)($this->request->getPost('total_telat') ?: 0);
        $izin     = (int)($this->request->getPost('total_izin') ?: 0);
        $sakit    = (int)($this->request->getPost('total_sakit') ?: 1);
        $alpa     = (int)($this->request->getPost('total_alpa') ?: 0);

        $db->table('sesi_kehadiran')->insert([
            'nama_sesi'   => $namaSesi,
            'tanggal'     => $tanggal,
            'waktu'       => $waktu,
            'lokasi'      => $lokasi,
            'total_hadir' => $hadir,
            'total_telat' => $telat,
            'total_izin'  => $izin,
            'total_sakit' => $sakit,
            'total_alpa'  => $alpa,
            'keterangan'  => $ket
        ]);

        return redirect()->to('/admin/kehadiran')->with('notif_type', 'add')
            ->with('notif_title', 'Sesi Kehadiran Dicatat!')
            ->with('notif_msg', "Sesi {$namaSesi} berhasil ditambahkan ke riwayat kehadiran.");
    }

    /**
     * =========================================================================
     * MANAJEMEN PENGGUNA (USER LOGIN MANAGEMENT)
     * =========================================================================
     */

    public function users()
    {
        $db = \Config\Database::connect();
        $users = $db->table('users u')
            ->select('u.*, ns.nama as santri_nama, ns.kelas as santri_kelas, ns.nis as santri_nis, ns.foto as santri_foto')
            ->join('nilai_santri ns', 'ns.id = u.santri_id', 'left')
            ->orderBy('u.id', 'ASC')
            ->get()
            ->getResultArray();

        $stats = [
            'total'       => count($users),
            'admin'       => 0,
            'instruktur'  => 0,
            'siswa'       => 0,
            'wali_santri' => 0,
            'aktif'       => 0,
        ];

        foreach ($users as $u) {
            if (isset($stats[$u['role']])) {
                $stats[$u['role']]++;
            }
            if (!empty($u['is_active'])) {
                $stats['aktif']++;
            }
        }

        $data = [
            'title' => 'Manajemen Pengguna (User Login)',
            'users' => $users,
            'stats' => $stats
        ];

        return view('admin/user_list', $data);
    }

    public function addUser()
    {
        $db = \Config\Database::connect();
        $santriList = $db->table('nilai_santri')
            ->select('id, nama, nis, kelas, cabang')
            ->orderBy('nama', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title'       => 'Tambah User Login Baru',
            'santri_list' => $santriList
        ];

        return view('admin/user_add', $data);
    }

    public function saveUser()
    {
        $nama       = trim((string)$this->request->getPost('nama'));
        $username   = trim((string)$this->request->getPost('username'));
        $password   = (string)$this->request->getPost('password');
        $role       = (string)$this->request->getPost('role');
        $santriId   = $this->request->getPost('santri_id') ? (int)$this->request->getPost('santri_id') : null;
        $isActive   = $this->request->getPost('is_active') !== null ? (int)$this->request->getPost('is_active') : 1;

        if (empty($nama) || empty($username) || empty($password) || empty($role)) {
            return redirect()->back()->withInput()->with('error', 'Nama, username, password, dan role wajib diisi!');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter!');
        }

        $allowedRoles = ['admin', 'instruktur', 'siswa', 'wali_santri'];
        if (!in_array($role, $allowedRoles, true)) {
            return redirect()->back()->withInput()->with('error', 'Role pengguna tidak valid!');
        }

        $db = \Config\Database::connect();
        $existing = $db->table('users')->where('username', $username)->get()->getRowArray();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', "Username '{$username}' sudah digunakan, silakan pilih username lain.");
        }

        $db->table('users')->insert([
            'nama'       => $nama,
            'username'   => $username,
            'password'   => password_hash($password, PASSWORD_BCRYPT),
            'role'       => $role,
            'santri_id'  => ($role === 'siswa' || $role === 'wali_santri') ? $santriId : null,
            'is_active'  => $isActive,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('admin/users'))
            ->with('notif_type', 'add')
            ->with('notif_title', 'User Baru Berhasil Dibuat!')
            ->with('notif_msg', "Pengguna {$nama} (@{$username}) dengan role '{$role}' berhasil ditambahkan.");
    }

    public function toggleUserStatus($id)
    {
        $currentUserId = (int)session()->get('user_id');
        $targetId = (int)$id;

        if ($targetId === $currentUserId) {
            return redirect()->to(base_url('admin/users'))->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', $targetId)->get()->getRowArray();
        if (!$user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        $db->table('users')->where('id', $targetId)->update(['is_active' => $newStatus]);

        $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->to(base_url('admin/users'))
            ->with('notif_type', 'edit')
            ->with('notif_title', 'Status User Diperbarui!')
            ->with('notif_msg', "Akun {$user['nama']} (@{$user['username']}) berhasil {$statusText}.");
    }

    public function deleteUser($id)
    {
        $currentUserId = (int)session()->get('user_id');
        $targetId = (int)$id;

        if ($targetId === $currentUserId) {
            return redirect()->to(base_url('admin/users'))->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif!');
        }

        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', $targetId)->get()->getRowArray();
        if (!$user) {
            return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');
        }

        $db->table('users')->where('id', $targetId)->delete();

        return redirect()->to(base_url('admin/users'))
            ->with('notif_type', 'delete')
            ->with('notif_title', 'User Dihapus!')
            ->with('notif_msg', "Akun {$user['nama']} (@{$user['username']}) telah dihapus dari sistem.");
    }

    // =========================================================================
    // MANAJEMEN PAPAN PENGUMUMAN DIKLAT (PEKANAN / RESMI / TIDAK RESMI)
    // =========================================================================

    public function announcements()
    {
        $announcementModel = new \App\Models\AnnouncementModel();
        $announcements = $announcementModel->getAllAnnouncements();

        $stats = [
            'total'       => count($announcements),
            'resmi'       => 0,
            'tidak_resmi' => 0,
            'agenda'      => 0,
            'aktif'       => 0,
        ];

        foreach ($announcements as $a) {
            if (isset($stats[$a['kategori']])) {
                $stats[$a['kategori']]++;
            }
            if (!empty($a['is_active'])) {
                $stats['aktif']++;
            }
        }

        $data = [
            'title'         => 'Papan Pengumuman Diklat',
            'announcements' => $announcements,
            'stats'         => $stats
        ];

        return view('admin/announcements', $data);
    }

    public function saveAnnouncement()
    {
        $judul           = trim((string)$this->request->getPost('judul'));
        $kategori        = (string)$this->request->getPost('kategori') ?: 'resmi';
        $isi             = trim((string)$this->request->getPost('isi'));
        $pekanKe         = trim((string)$this->request->getPost('pekan_ke')) ?: 'Pekan Ini';
        $tanggalKegiatan = $this->request->getPost('tanggal_kegiatan') ?: null;
        $waktuKegiatan   = trim((string)$this->request->getPost('waktu_kegiatan')) ?: null;
        $lokasi          = trim((string)$this->request->getPost('lokasi')) ?: 'Kampus Diklat RGI';
        $penyelenggara   = trim((string)$this->request->getPost('penyelenggara')) ?: 'Diklat RGI';
        $isPinned        = $this->request->getPost('is_pinned') ? 1 : 0;
        $isActive        = $this->request->getPost('is_active') !== null ? (int)$this->request->getPost('is_active') : 1;

        if (empty($judul) || empty($isi)) {
            return redirect()->back()->withInput()->with('error', 'Judul dan isi pengumuman wajib diisi!');
        }

        $announcementModel = new \App\Models\AnnouncementModel();
        $announcementModel->insert([
            'judul'            => $judul,
            'kategori'         => $kategori,
            'isi'              => $isi,
            'pekan_ke'         => $pekanKe,
            'tanggal_kegiatan' => $tanggalKegiatan,
            'waktu_kegiatan'   => $waktuKegiatan,
            'lokasi'           => $lokasi,
            'penyelenggara'    => $penyelenggara,
            'is_pinned'        => $isPinned,
            'is_active'        => $isActive,
        ]);

        return redirect()->to(base_url('admin/announcements'))
            ->with('notif_type', 'add')
            ->with('notif_title', 'Pengumuman Berhasil Diterbitkan!')
            ->with('notif_msg', "Pengumuman '{$judul}' telah terpasang di papan pengumuman landing page.");
    }

    public function updateAnnouncement()
    {
        $id = (int)$this->request->getPost('id');
        $announcementModel = new \App\Models\AnnouncementModel();
        $item = $announcementModel->find($id);

        if (!$item) {
            return redirect()->to(base_url('admin/announcements'))->with('error', 'Pengumuman tidak ditemukan.');
        }

        $judul           = trim((string)$this->request->getPost('judul'));
        $kategori        = (string)$this->request->getPost('kategori') ?: 'resmi';
        $isi             = trim((string)$this->request->getPost('isi'));
        $pekanKe         = trim((string)$this->request->getPost('pekan_ke')) ?: 'Pekan Ini';
        $tanggalKegiatan = $this->request->getPost('tanggal_kegiatan') ?: null;
        $waktuKegiatan   = trim((string)$this->request->getPost('waktu_kegiatan')) ?: null;
        $lokasi          = trim((string)$this->request->getPost('lokasi')) ?: 'Kampus Diklat RGI';
        $penyelenggara   = trim((string)$this->request->getPost('penyelenggara')) ?: 'Diklat RGI';
        $isPinned        = $this->request->getPost('is_pinned') ? 1 : 0;
        $isActive        = $this->request->getPost('is_active') !== null ? (int)$this->request->getPost('is_active') : 1;

        if (empty($judul) || empty($isi)) {
            return redirect()->back()->withInput()->with('error', 'Judul dan isi pengumuman wajib diisi!');
        }

        $announcementModel->update($id, [
            'judul'            => $judul,
            'kategori'         => $kategori,
            'isi'              => $isi,
            'pekan_ke'         => $pekanKe,
            'tanggal_kegiatan' => $tanggalKegiatan,
            'waktu_kegiatan'   => $waktuKegiatan,
            'lokasi'           => $lokasi,
            'penyelenggara'    => $penyelenggara,
            'is_pinned'        => $isPinned,
            'is_active'        => $isActive,
        ]);

        return redirect()->to(base_url('admin/announcements'))
            ->with('notif_type', 'edit')
            ->with('notif_title', 'Pengumuman Berhasil Diperbarui!')
            ->with('notif_msg', "Pengumuman '{$judul}' telah berhasil diupdate.");
    }

    public function toggleAnnouncementStatus($id)
    {
        $id = (int)$id;
        $announcementModel = new \App\Models\AnnouncementModel();
        $item = $announcementModel->find($id);

        if (!$item) {
            return redirect()->to(base_url('admin/announcements'))->with('error', 'Pengumuman tidak ditemukan.');
        }

        $newStatus = $item['is_active'] ? 0 : 1;
        $announcementModel->update($id, ['is_active' => $newStatus]);

        $statusText = $newStatus ? 'ditampilkan kembali' : 'disembunyikan (arsip)';
        return redirect()->to(base_url('admin/announcements'))
            ->with('notif_type', 'edit')
            ->with('notif_title', 'Status Pengumuman Diubah!')
            ->with('notif_msg', "Pengumuman '{$item['judul']}' kini {$statusText} di papan pengumuman.");
    }

    public function deleteAnnouncement($id)
    {
        $id = (int)$id;
        $announcementModel = new \App\Models\AnnouncementModel();
        $item = $announcementModel->find($id);

        if (!$item) {
            return redirect()->to(base_url('admin/announcements'))->with('error', 'Pengumuman tidak ditemukan.');
        }

        $announcementModel->delete($id);

        return redirect()->to(base_url('admin/announcements'))
            ->with('notif_type', 'delete')
            ->with('notif_title', 'Pengumuman Dihapus!')
            ->with('notif_msg', "Pengumuman '{$item['judul']}' telah dihapus dari papan pengumuman.");
    }
}
