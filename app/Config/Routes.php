<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public Auth Routes
$routes->match(['GET', 'HEAD'], 'login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->match(['GET', 'HEAD'], 'logout', 'Auth::logout');

// Root Route (Admin Dashboard / Role Dispatcher)
$routes->match(['GET', 'HEAD'], '/', 'Admin::index', ['filter' => 'role:admin']);

// Admin Routes (Full Access)
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
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
