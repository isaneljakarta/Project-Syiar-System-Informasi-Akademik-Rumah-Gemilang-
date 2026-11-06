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

        $name            = $this->request->getPost('nama');
        $class           = $this->request->getPost('kelas');
        $tauhid          = $this->request->getPost('tauhid');
        $fiqih           = $this->request->getPost('fiqih');
        $b_ing           = $this->request->getPost('b_ing');
        $menulis_kreatif = $this->request->getPost('menulis_kreatif');
        $adab_akhlaq     = $this->request->getPost('adab_akhlaq') ?: 85;
        $kehadiran       = $this->request->getPost('kehadiran') ?: 95;

        // Validasi sederhana untuk memastikan data wajib tidak kosong
        if (empty($name) || empty($class) || empty($tauhid) || empty($fiqih) || empty($b_ing) || empty($menulis_kreatif)) {
            return redirect()->back()->withInput()->with('error', 'Semua kolom nilai wajib diisi!');
        }

        $dataToSave = [
            'nama'            => $name,
            'kelas'           => $class,
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
            ->with('notif_msg', "Data santri {$name} berhasil ditambahkan!");
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
        $id = $this->request->getPost('id');

        $dataToUpdate = [
            'nama'            => $this->request->getPost('nama'),
            'kelas'           => $this->request->getPost('kelas'),
            'tauhid'          => $this->request->getPost('tauhid'),
            'fiqih'           => $this->request->getPost('fiqih'),
            'b_ing'           => $this->request->getPost('b_ing'),
            'menulis_kreatif' => $this->request->getPost('menulis_kreatif'),
            'adab_akhlaq'     => $this->request->getPost('adab_akhlaq') ?? 85,
            'kehadiran'       => $this->request->getPost('kehadiran') ?? 95,
        ];

        $studentModel->update($id, $dataToUpdate);

        return redirect()->to('/admin/data')
            ->with('notif_type', 'edit')
            ->with('notif_title', 'Data Santri Diperbarui!')
            ->with('notif_msg', "Data santri {$dataToUpdate['nama']} ({$id}) berhasil diedit.");
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
}
