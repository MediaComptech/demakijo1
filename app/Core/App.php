<?php

namespace App\Core;

use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;

/**
 * Kelas App
 * 
 * Kelas utama (bootstrap) untuk menjalankan framework.
 * Menghandle inisialisasi environment, database, dan session.
 */
class App
{
    /**
     * Menjalankan inisialisasi aplikasi.
     * Dipanggil di public/index.php
     */
    public static function boot()
    {
        // 1. Muat file .env
        self::loadDotenv();

        // 2. Mulai Session
        Session::start();

        // 3. Setup Database (Eloquent)
        self::setupDatabase();

        // 4. Setup View Template Engine
        View::init();

        // 5. Register aliases for Facades used in views
        class_alias(\App\Core\Auth::class, 'Auth');
    }

    /**
     * Memuat variabel dari file .env
     */
    private static function loadDotenv()
    {
        // Pastikan path ke .env sesuai (satu tingkat di atas folder app)
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        
        try {
            $dotenv->load();
        } catch (\Exception $e) {
            // Jika file .env tidak ada, abaikan atau tampilkan pesan error
            die("File .env tidak ditemukan. Silakan copy .env.example menjadi .env");
        }
    }

    /**
     * Mengatur koneksi Standalone Eloquent Database.
     */
    private static function setupDatabase()
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => $_ENV['DB_CONNECTION'] ?? 'mysql',
            'host'      => $_ENV['DB_HOST'] ?? '127.0.0.1',
            'port'      => $_ENV['DB_PORT'] ?? '3306',
            'database'  => $_ENV['DB_DATABASE'] ?? 'forge',
            'username'  => $_ENV['DB_USERNAME'] ?? 'forge',
            'password'  => $_ENV['DB_PASSWORD'] ?? '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        // Mengaktifkan Eloquent secara global
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * Alias fungsi render view.
     */
    public static function view($view, $data = [])
    {
        return View::render($view, $data);
    }
}
