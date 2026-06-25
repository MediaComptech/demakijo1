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

// Global exception handler — tangkap semua uncaught exception dan log-kan
set_exception_handler(function (\Throwable $e) {
    $msg = '[EXCEPTION] ' . get_class($e) . ': ' . $e->getMessage()
         . ' in ' . $e->getFile() . ':' . $e->getLine();
    error_log($msg);
    if (!headers_sent()) {
        http_response_code(500);
    }
    // Tampilkan pesan error yang aman (tanpa detail sensitif)
    echo '<h2>Terjadi kesalahan sistem. Silakan coba lagi atau hubungi admin.</h2>';
    // Uncomment baris di bawah untuk mode debug (JANGAN di production):
    // echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    exit;
});

// Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// Inisialisasi Aplikasi (Load .env, Database, View Engine, Session)
\App\Core\App::boot();

// Load definisi rute aplikasi
require __DIR__ . '/../routes/web.php';

// Eksekusi rute yang cocok dengan URL saat ini
\App\Core\Router::dispatch();

