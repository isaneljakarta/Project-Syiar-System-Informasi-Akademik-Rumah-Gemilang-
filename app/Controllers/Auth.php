<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        // Jika sudah login, langsung arahkan ke dashboard masing-masing
        if (session()->get('logged_in')) {
            return $this->redirectByRole(session()->get('role'));
        }

        $data = [
            'title' => 'Masuk ke Sistem - Syiar Gemilang'
        ];

        return view('auth/login', $data);
    }

    public function attemptLogin()
    {
        $username = trim((string)$this->request->getPost('username'));
        $password = (string)$this->request->getPost('password');

        if (empty($username) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Username dan password wajib diisi.');
        }

        $db = \Config\Database::connect();
        $user = $db->table('users')
                   ->where('username', $username)
                   ->where('is_active', 1)
                   ->get()
                   ->getRowArray();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau password yang Anda masukkan salah.');
        }

        // Set session login
        session()->set([
            'user_id'   => (int)$user['id'],
            'username'  => $user['username'],
            'nama'      => $user['nama'],
            'role'      => $user['role'],
            'santri_id' => $user['santri_id'] ? (int)$user['santri_id'] : null,
            'logged_in' => true,
        ]);

        return $this->redirectByRole($user['role']);
    }

    public function logout()
    {
        session()->remove(['user_id', 'username', 'nama', 'role', 'santri_id', 'logged_in']);
        return redirect()->to(base_url('login'))->with('success', 'Anda telah berhasil keluar dari sistem.');
    }

    private function redirectByRole(string $role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->to(base_url('/'));
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
}

