<?php

/**
 * Entry Point Aplikasi Native PHP MVC
 * 
 * File ini adalah gerbang utama yang dipanggil oleh server web.
 */

// Menampilkan error untuk mode development (ubah ke 0 di production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// Inisialisasi Aplikasi (Load .env, Database, View Engine, Session)
\App\Core\App::boot();

// Load definisi rute aplikasi
require __DIR__ . '/../routes/web.php';

// Eksekusi rute yang cocok dengan URL saat ini
\App\Core\Router::dispatch();
