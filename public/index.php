<?php

/**
 * Entry Point Aplikasi Native PHP MVC
 * 
 * File ini adalah gerbang utama yang dipanggil oleh server web.
 */

// Production: sembunyikan error dari browser, catat ke error_log server
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// Inisialisasi Aplikasi (Load .env, Database, View Engine, Session)
\App\Core\App::boot();

// Load definisi rute aplikasi
require __DIR__ . '/../routes/web.php';

// Eksekusi rute yang cocok dengan URL saat ini
\App\Core\Router::dispatch();
