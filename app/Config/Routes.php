<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public Auth Routes
$routes->match(['GET', 'HEAD'], 'login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->match(['GET', 'HEAD'], 'logout', 'Auth::logout');
$routes->match(['GET', 'HEAD'], 'ganti-password', 'Auth::changePassword');
$routes->post('ganti-password', 'Auth::updatePassword');

// Root Route (Landing Page sekaligus Login Page)
$routes->match(['GET', 'HEAD'], '/', 'Home::index');

// Admin Routes (Full Access)
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->match(['GET', 'HEAD'], '/', 'Admin::index');
    $routes->match(['GET', 'HEAD'], 'dashboard', 'Admin::index');
    $routes->get('data', 'Admin::dataStudent');
    $routes->get('add', 'Admin::addStudent');
    $routes->post('save', 'Admin::saveStudent');
    $routes->post('update', 'Admin::update');
    $routes->post('store', 'Admin::store');
    $routes->post('delete/(:segment)', 'Admin::delete/$1');
    $routes->get('pemeringkatan', 'Admin::pemeringkatan');
    $routes->get('kehadiran', 'Admin::kehadiran');
    $routes->post('kehadiran/add_sesi', 'Admin::addSesiKehadiran');
    $routes->post('kehadiran/catat', 'Admin::catatPresensiSantri');

    // User Management Routes
    $routes->get('users', 'Admin::users');
    $routes->get('users/add', 'Admin::addUser');
    $routes->post('users/save', 'Admin::saveUser');
    $routes->post('users/toggle/(:segment)', 'Admin::toggleUserStatus/$1');
    $routes->post('users/delete/(:segment)', 'Admin::deleteUser/$1');

    // Announcement / Papan Pengumuman Diklat Routes
    $routes->get('announcements', 'Admin::announcements');
    $routes->post('announcements/save', 'Admin::saveAnnouncement');
    $routes->post('announcements/update', 'Admin::updateAnnouncement');
    $routes->post('announcements/toggle/(:segment)', 'Admin::toggleAnnouncementStatus/$1');
    $routes->post('announcements/delete/(:segment)', 'Admin::deleteAnnouncement/$1');
});

// Instruktur Routes (Input/Update Nilai & Presensi)
$routes->group('instruktur', ['filter' => 'role:instruktur'], function ($routes) {
    $routes->match(['GET', 'HEAD'], '/', 'Instruktur::index');
    $routes->match(['GET', 'HEAD'], 'kelas', 'Instruktur::kelas');
    $routes->match(['GET', 'HEAD'], 'nilai_kelas', 'Instruktur::kelas');
    $routes->match(['GET', 'HEAD'], 'nilai', 'Instruktur::nilai');
    $routes->post('nilai/update', 'Instruktur::updateNilai');
    $routes->match(['GET', 'HEAD'], 'kehadiran', 'Instruktur::kehadiran');
    $routes->post('kehadiran/catat', 'Instruktur::catatPresensi');
    
    // Download Rekapan Nilai & Presensi (CSV)
    $routes->get('download-nilai-csv', 'Instruktur::downloadRekapNilaiCsv');
    $routes->get('download-absensi-csv', 'Instruktur::downloadRekapAbsensiCsv');
});

// Siswa Routes (Presensi Mandiri Per Nama Santri)
$routes->group('siswa', ['filter' => 'role:siswa'], function ($routes) {
    $routes->get('/', 'Siswa::index');
    $routes->get('presensi', 'Siswa::presensi');
    $routes->post('presensi/catat', 'Siswa::catatPresensi');
});

// Wali Santri Routes (Hanya Melihat Saja Secara Detail Tanpa Mengisi)
$routes->group('wali', ['filter' => 'role:wali_santri'], function ($routes) {
    $routes->get('/', 'Wali::index');
});
