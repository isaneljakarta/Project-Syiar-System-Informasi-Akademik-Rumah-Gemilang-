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
            return redirect()->to(base_url('login'))->withInput()->with('error', 'Nomor Induk Santri (NIS) / Username dan kata sandi wajib diisi.');
        }

        $db = \Config\Database::connect();
        $user = $db->table('users')
                   ->where('username', $username)
                   ->where('is_active', 1)
                   ->get()
                   ->getRowArray();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->to(base_url('login'))->withInput()->with('error', 'Username atau kata sandi yang Anda masukkan salah.');
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

    public function changePassword()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $userId = session()->get('user_id');
        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', $userId)->get()->getRowArray();

        $data = [
            'title' => 'Pengaturan Kata Sandi',
            'user'  => $user
        ];

        return view('auth/change_password', $data);
    }

    public function updatePassword()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $userId = (int)session()->get('user_id');
        $currentPassword = (string)$this->request->getPost('current_password');
        $newPassword = (string)$this->request->getPost('new_password');
        $confirmPassword = (string)$this->request->getPost('confirm_password');

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            return redirect()->back()->with('error', 'Semua kolom kata sandi wajib diisi!');
        }

        if (strlen($newPassword) < 6) {
            return redirect()->back()->with('error', 'Kata sandi baru minimal terdiri dari 6 karakter!');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi kata sandi baru tidak sesuai dengan kata sandi baru!');
        }

        $db = \Config\Database::connect();
        $user = $db->table('users')->where('id', $userId)->get()->getRowArray();

        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Kata sandi saat ini yang Anda masukkan salah!');
        }

        // Simpan password baru
        $db->table('users')->where('id', $userId)->update([
            'password' => password_hash($newPassword, PASSWORD_BCRYPT)
        ]);

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui! Silakan gunakan kata sandi baru Anda.');
    }

    private function redirectByRole(string $role)
    {
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
}

