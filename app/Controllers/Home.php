<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;

class Home extends BaseController
{
    public function index()
    {
        // Jika sudah login, langsung arahkan ke dashboard masing-masing
        if (session()->get('logged_in')) {
            $role = (string)session()->get('role');
            switch ($role) {
                case 'admin':
                    return redirect()->to(base_url('admin'));
                case 'instruktur':
                    return redirect()->to(base_url('instruktur'));
                case 'siswa':
                    return redirect()->to(base_url('siswa'));
                case 'wali_santri':
                    return redirect()->to(base_url('wali'));
                default:
                    return redirect()->to(base_url('login'));
            }
        }

        $announcementModel = new AnnouncementModel();

        $data = [
            'title'         => 'Syiar Gemilang – Satu NIS untuk semua urusan akademik',
            'announcements' => $announcementModel->getActiveAnnouncements(),
        ];

        return view('landing', $data);
    }
}
