<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Tetapkan halaman login (Auth::index) sebagai halaman utama
$routes->get('/', 'Auth::index');

// Grup untuk semua rute Autentikasi (login, logout, proses)
$routes->group('auth', static function ($routes) {
    $routes->get('/', 'Auth::index'); // Halaman login jika diakses via /auth
    $routes->post('proses_login', 'Auth::proses_login'); // Proses login
    $routes->get('logout', 'Auth::logout'); // <-- INI SOLUSI 404 KAMU
});

// $routes->get('mahasiswa', 'Mahasiswa::index');

$routes->group('mahasiswa', static function ($routes) {
    $routes->get('/', 'Mahasiswa::index'); // Ini untuk /mahasiswa
    $routes->get('krs', 'Mahasiswa::krs'); // Ini untuk /mahasiswa/krs
    $routes->get('khs', 'Mahasiswa::khs'); // Ini untuk /mahasiswa/khs
    
    // Ini untuk fungsi 'tambah_krs' yang butuh ID
    $routes->get('tambah_krs/(:num)', 'Mahasiswa::tambah_krs/$1'); 
    
    // Ini untuk fungsi 'hapus_krs' yang butuh ID
    $routes->get('hapus_krs/(:num)', 'Mahasiswa::hapus_krs/$1');
});

// TAMBAHKAN GRUP BARU INI UNTUK DOSEN
$routes->group('dosen', static function ($routes) {
    $routes->get('/', 'Dosen::index'); // Halaman dashboard Dosen

    // Rute untuk halaman isi nilai (pakai angka :num)
    $routes->get('isi_nilai/(:num)', 'Dosen::isi_nilai/$1');

    // Rute untuk PROSES simpan nilai (pakai POST)
    $routes->post('simpan_nilai', 'Dosen::simpan_nilai');
});

$routes->group('admin', static function ($routes) {
    $routes->get('/', 'Admin::index'); // Dashboard

    // Rute Mahasiswa
    $routes->get('mahasiswa', 'Admin::mahasiswa');
    $routes->post('tambah_mahasiswa', 'Admin::tambah_mahasiswa'); // POST untuk tambah
    $routes->get('hapus_mahasiswa/(:num)', 'Admin::hapus_mahasiswa/$1'); // GET untuk hapus
    $routes->get('edit_mahasiswa/(:num)', 'Admin::edit_mahasiswa/$1'); // GET form edit
    $routes->post('proses_edit_mahasiswa', 'Admin::proses_edit_mahasiswa'); // POST untuk edit

    // Rute Dosen
    $routes->get('dosen', 'Admin::dosen');
    $routes->post('tambah_dosen', 'Admin::tambah_dosen');
    $routes->get('hapus_dosen/(:num)', 'Admin::hapus_dosen/$1');
    $routes->get('edit_dosen/(:num)', 'Admin::edit_dosen/$1');
    $routes->post('proses_edit_dosen', 'Admin::proses_edit_dosen');
        
    // Rute Mata Kuliah
    $routes->get('mata_kuliah', 'Admin::mata_kuliah');
    $routes->post('tambah_mata_kuliah', 'Admin::tambah_mata_kuliah');
    $routes->get('hapus_mata_kuliah/(:num)', 'Admin::hapus_mata_kuliah/$1');
    $routes->get('edit_mata_kuliah/(:num)', 'Admin::edit_mata_kuliah/$1');
    $routes->post('proses_edit_mata_kuliah', 'Admin::proses_edit_mata_kuliah');
        
    // Rute Ruangan
    $routes->get('ruangan', 'Admin::ruangan');
    $routes->post('tambah_ruangan', 'Admin::tambah_ruangan');
    $routes->get('hapus_ruangan/(:num)', 'Admin::hapus_ruangan/$1');
    $routes->get('edit_ruangan/(:num)', 'Admin::edit_ruangan/$1');
    $routes->post('proses_edit_ruangan', 'Admin::proses_edit_ruangan');
        
    // Rute Jadwal
    $routes->get('jadwal', 'Admin::jadwal');
    $routes->post('tambah_jadwal', 'Admin::tambah_jadwal');
    $routes->get('hapus_jadwal/(:num)', 'Admin::hapus_jadwal/$1');
    $routes->get('edit_jadwal/(:num)', 'Admin::edit_jadwal/$1');
    $routes->post('proses_edit_jadwal', 'Admin::proses_edit_jadwal');

    // Rute Ganti Password
    $routes->get('form_ganti_password/(:segment)/(:num)', 'Admin::form_ganti_password/$1/$2'); // :segment untuk role, :num untuk kode_peran
    $routes->post('proses_ganti_password', 'Admin::proses_ganti_password');
    });