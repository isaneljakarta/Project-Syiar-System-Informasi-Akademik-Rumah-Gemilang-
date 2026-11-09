<?php

namespace App\Controllers;

use App\Models\StudentModel;

class Siswa extends BaseController
{
    public function index()
    {
        $studentModel = new StudentModel();
        $santriId = (int)session()->get('santri_id');

        // Ambil data nilai santri yang sedang login dengan formula terbobot
        $santri = $studentModel->select('id, nama, nis, cabang, kelas, angkatan, status, foto, tauhid, b_ing, menulis_kreatif, fiqih, adab_akhlaq, kehadiran,
            ROUND((tauhid + b_ing + menulis_kreatif + fiqih) / 4, 2) as rata_akademik,
            ROUND((((tauhid + b_ing + menulis_kreatif + fiqih) / 4 * 0.8) + (adab_akhlaq * 0.2)), 2) as rata_rata')
            ->find($santriId);

        if (!$santri) {
            return redirect()->to('/login')->with('error', 'Data santri Anda tidak ditemukan.');
        }

        // Cari ranking santri di seluruh sekolah
        $allRanking = $studentModel->getAllRanking();
        $rankPosition = 1;
        foreach ($allRanking as $idx => $s) {
            if ((int)$s['id'] === $santriId) {
                $rankPosition = $idx + 1;
                break;
            }
        }

        $db = \Config\Database::connect();
        // Ambil log presensi santri ini sendiri
        $myLogs = $db->table('presensi_log p')
                     ->select('p.*, s.nama_sesi, s.waktu, s.lokasi, s.tanggal as sesi_tanggal')
                     ->join('sesi_kehadiran s', 's.id = p.sesi_id', 'left')
                     ->where('p.santri_id', $santriId)
                     ->orderBy('p.tanggal', 'DESC')
                     ->orderBy('p.id', 'DESC')
                     ->get()
                     ->getResultArray();

        // Rekapitulasi presensi santri ini
        $rekapBulanan = $studentModel->getRekapBulananSantri();
        $myRekap = $rekapBulanan[$santriId] ?? [
            'total_sesi'  => count($myLogs),
            'count_hadir' => 0,
            'count_telat' => 0,
            'count_sakit' => 0,
            'count_absen' => 0,
        ];

        $data = [
            'title'          => 'Dashboard Santri',
            'santri'         => $santri,
            'rank'           => $rankPosition,
            'total_siswa'    => $studentModel->countAll(),
            'my_logs'        => $myLogs,
            'my_rekap'       => $myRekap,
            'sesi_kehadiran' => $studentModel->getSesiKehadiran(),
        ];

        return view('siswa/dashboard', $data);
    }

    public function presensi()
    {
        $studentModel = new StudentModel();
        $santriId = (int)session()->get('santri_id');

        $santri = $studentModel->find($santriId);

        $db = \Config\Database::connect();
        $myLogs = $db->table('presensi_log p')
                     ->select('p.*, s.nama_sesi, s.waktu, s.lokasi, s.tanggal as sesi_tanggal')
                     ->join('sesi_kehadiran s', 's.id = p.sesi_id', 'left')
                     ->where('p.santri_id', $santriId)
                     ->orderBy('p.tanggal', 'DESC')
                     ->orderBy('p.id', 'DESC')
                     ->get()
                     ->getResultArray();

        $rekapBulanan = $studentModel->getRekapBulananSantri();
        $myRekap = $rekapBulanan[$santriId] ?? [
            'total_sesi'  => count($myLogs),
            'count_hadir' => 0,
            'count_telat' => 0,
            'count_sakit' => 0,
            'count_absen' => 0,
        ];

        $data = [
            'title'          => 'Presensi Mandiri Santri',
            'santri'         => $santri,
            'sesi_kehadiran' => $studentModel->getSesiKehadiran(),
            'my_logs'        => $myLogs,
            'my_rekap'       => $myRekap,
        ];

        return view('siswa/presensi', $data);
    }

    public function catatPresensi()
    {
        $studentModel = new StudentModel();
        
        // PENTING: ID santri diambil murni dari session login santri yang bersangkutan!
        // Santri tidak bisa mengisi untuk santri lain.
        $santriId = (int)session()->get('santri_id');

        $sesiId     = (int)$this->request->getPost('sesi_id');
        $status     = $this->request->getPost('status'); // Hadir, Telat, Sakit, Absen
        $tanggal    = $this->request->getPost('tanggal') ?: date('Y-m-d');
        $keterangan = $this->request->getPost('keterangan') ?: 'Presensi Mandiri Siswa';

        if (!$sesiId || !$status) {
            return redirect()->to('/siswa/presensi')->with('notif_type', 'delete')
                ->with('notif_title', 'Gagal Presensi')
                ->with('notif_msg', 'Pilih sesi pertemuan dan status kehadiran Anda.');
        }

        $res = $studentModel->catatPresensi($santriId, $sesiId, $status, $tanggal, $keterangan);

        return redirect()->to('/siswa/presensi')->with('notif_type', 'add')
            ->with('notif_title', "Presensi Berhasil Dicatat!")
            ->with('notif_msg', "Status kehadiran Anda ({$status}) telah berhasil tersimpan pada sesi '{$res['sesi_nama']}'.");
    }
}

