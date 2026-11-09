<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = session()->get('role');

        if (!empty($arguments)) {
            if (!in_array($userRole, $arguments, true)) {
                // Redirect user to their own home dashboard based on role
                $target = base_url('login');
                if ($userRole === 'admin') {
                    $target = base_url('admin');
                } elseif ($userRole === 'instruktur') {
                    $target = base_url('instruktur');
                } elseif ($userRole === 'siswa') {
                    $target = base_url('siswa');
                } elseif ($userRole === 'wali_santri') {
                    $target = base_url('wali');
                }

                return redirect()->to($target)->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

