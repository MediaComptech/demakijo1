<?php

use App\Core\Router;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah rute-rute web untuk aplikasi Anda didaftarkan.
| Sintaks menggunakan Router buatan sendiri (Native PHP MVC).
| 
| Contoh penggunaan:
| Router::get('/url', 'NamaController@namaFungsi');
| Router::post('/url/submit', 'NamaController@prosesSubmit');
|
*/

// --- RUTE PUBLIK ---
Router::get('/', 'HomeController@index');
Router::get('/berita', 'BeritaController@index');
Router::get('/berita/{slug}', 'BeritaController@show');
Router::get('/profil', 'ProfilController@index');

// --- RUTE PPDB ---
Router::get('/ppdb-online', 'PpdbController@form');
Router::post('/ppdb/daftar', 'PpdbController@store');

// --- RUTE OTENTIKASI ---
Router::get('/login', 'AuthController@loginForm');
Router::post('/login', 'AuthController@loginAction');
Router::post('/logout', 'AuthController@logoutAction');

// --- RUTE ADMIN (Dashboard) ---
Router::get('/dashboard', 'Admin\DashboardController@index');
Router::get('/admin/siswa', 'Admin\SiswaController@index');
// Tambahkan rute admin lainnya sesuai kebutuhan...

