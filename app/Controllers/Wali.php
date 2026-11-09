<?php

namespace App\Controllers;

use App\Models\StudentModel;

class Wali extends BaseController
{
    public function index()
    {
        $studentModel = new StudentModel();
        $santriId = (int)session()->get('santri_id');

        // Ambil data santri (anak dari wali)
        $santri = $studentModel->select('id, nama, nis, cabang, kelas, angkatan, status, foto, tauhid, b_ing, menulis_kreatif, fiqih, adab_akhlaq, kehadiran,
            ROUND((tauhid + b_ing + menulis_kreatif + fiqih) / 4, 2) as rata_akademik,
            ROUND((((tauhid + b_ing + menulis_kreatif + fiqih) / 4 * 0.8) + (adab_akhlaq * 0.2)), 2) as rata_rata')
            ->find($santriId);

        if (!$santri) {
            return redirect()->to('/login')->with('error', 'Data santri putra/putri Anda tidak ditemukan.');
        }

        // Cari ranking santri
        $allRanking = $studentModel->getAllRanking();
        $rankPosition = 1;
        foreach ($allRanking as $idx => $s) {
            if ((int)$s['id'] === $santriId) {
                $rankPosition = $idx + 1;
                break;
            }
        }

        $db = \Config\Database::connect();
        // Ambil log kehadiran santri
        $myLogs = $db->table('presensi_log p')
                     ->select('p.*, s.nama_sesi, s.waktu, s.lokasi, s.tanggal as sesi_tanggal')
                     ->join('sesi_kehadiran s', 's.id = p.sesi_id', 'left')
                     ->where('p.santri_id', $santriId)
                     ->orderBy('p.tanggal', 'DESC')
                     ->orderBy('p.id', 'DESC')
                     ->get()
                     ->getResultArray();

        // Rekapitulasi presensi
        $rekapBulanan = $studentModel->getRekapBulananSantri();
        $myRekap = $rekapBulanan[$santriId] ?? [
            'total_sesi'  => count($myLogs),
            'count_hadir' => 0,
            'count_telat' => 0,
            'count_sakit' => 0,
            'count_absen' => 0,
        ];

        $data = [
            'title'       => 'Portal Wali Santri',
            'santri'      => $santri,
            'rank'        => $rankPosition,
            'total_siswa' => $studentModel->countAll(),
            'my_logs'     => $myLogs,
            'my_rekap'    => $myRekap,
        ];

        return view('wali/dashboard', $data);
    }
}

