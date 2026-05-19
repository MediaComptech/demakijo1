# Native PHP MVC - Demakijo 1 Konversi

Repositori ini adalah hasil konversi dari aplikasi **Laravel** ke arsitektur **Native PHP MVC** yang dirancang khusus untuk mempermudah *maintenance* dan pengembangan oleh *junior programmer* maupun model AI berbiaya rendah.

Proses konversi ini disusun berdasarkan issue rencana implementasi [#1](https://github.com/MediaComptech/demakijo1-konversi/issues/1).

## 🚀 Fitur Utama
1. **No Magic Code**: Semua alur eksekusi bersifat eksplisit dan transparan.
2. **Standalone Eloquent**: Tetap menggunakan fitur relasi database yang sangat kaya dari Laravel tanpa perlu memuat keseluruhan framework Laravel. Model existing dijamin 100% kompatibel.
3. **BladeOne Template Engine**: Mendukung syntax Blade seperti `@if`, `@foreach`, dan `@extends` tanpa memerlukan engine Laravel.
4. **Sistem Routing Native**: Menggunakan router sederhana `Router::get('/path', 'Controller@method')`.
5. **Keamanan Bawaan**: Memiliki mekanisme proteksi CSRF, filter XSS, dan PDO binding bawaan Eloquent untuk mencegah SQL Injection.

## 📂 Struktur Direktori

```text
project-root/
│
├── app/
│   ├── Core/        -> Core framework MVC (App, Router, Controller, Model, View, Security, Session)
│   ├── Controllers/ -> Base application controllers
│   ├── Models/      -> Standalone Eloquent models
│   ├── Views/       -> Blade templates (belum termigrasi seluruhnya)
│   ├── Middleware/  -> (TBA) Middlewares
│   ├── Services/    -> Business logic (bila diperlukan)
│   └── Helpers/     -> Global helper functions (url, asset, view, json, dll)
│
├── config/          -> Konfigurasi utama aplikasi
├── public/          -> Webroot dan entry point (index.php), aset CSS/JS, uploads
├── routes/          -> Definisi routing (web.php)
├── storage/         -> Tempat penyimpanan cache view, log, dan temp file
├── vendor/          -> Composer dependencies
├── .env.example     -> Template konfigurasi environment
└── composer.json    -> Dependensi (illuminate/database, eftec/bladeone, vlucas/phpdotenv)
```

## ⚙️ Cara Instalasi & Setup

Aplikasi ini didesain agar sangat ramah *shared hosting* dan VPS.

### Kebutuhan Sistem
- PHP >= 8.2
- Composer
- Ekstensi PHP: PDO, mbstring, openssl.

### Langkah-Langkah

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/MediaComptech/demakijo1-konversi.git
   cd demakijo1-konversi
   ```
2. **Install Dependensi**:
   ```bash
   composer install
   ```
3. **Konfigurasi Environment**:
   Salin file `.env.example` ke `.env` dan atur informasi koneksi database Anda (sama persis dengan Laravel).
   ```bash
   cp .env.example .env
   ```
4. **Jalankan Aplikasi** (Local Development):
   Arahkan terminal ke folder `public` dan gunakan PHP built-in server:
   ```bash
   php -S localhost:8000 -t public
   ```
   Buka `http://localhost:8000` di browser Anda.

## 💻 Panduan Pengembangan (Untuk Junior & AI)

### 1. Cara Tambah Route Baru
Buka file `routes/web.php` dan tambahkan rute Anda:
```php
Router::get('/tentang-kami', 'HalamanController@tentang');
Router::post('/kontak/kirim', 'KontakController@kirimPesan');
```

### 2. Cara Tambah Controller Baru
Buat file di `app/Controllers/` dengan nama kelas yang sesuai (misal: `HalamanController.php`):
```php
<?php
namespace App\Controllers;
use App\Core\Controller;

class HalamanController extends Controller {
    public function tentang() {
        return $this->view('tentang-kami', ['title' => 'Tentang Kami']);
    }
}
```

### 3. Cara Menggunakan Model (Standalone Eloquent)
Semua model yang ada (seperti `Siswa.php`, `User.php`) sudah berada di folder `app/Models/` dan beroperasi persis sama dengan Laravel karena menggunakan Standalone Eloquent. Anda bisa melakukan pemanggilan metode standar seperti `find()`, `where()`, `hasMany()`, dll.
```php
$siswa = \App\Models\Siswa::with('kelas')->get();
```

### 4. Proteksi Form (CSRF)
Di setiap form POST, Anda wajib memanggil fungsi helper `csrf_field()` di dalam view. Di Controller, Anda tidak perlu mengecek secara manual asalkan token dikirim. Jika ingin mengecek secara manual:
```php
\App\Core\Security::verifyCsrfToken();
```

## 🚀 Panduan Deployment (Hosting / VPS)

### Shared Hosting (cPanel / DirectAdmin)
Aplikasi ini sudah dipisahkan antara layer sistem dan layer publik (`public/`). Cara termudah untuk *deploy* di shared hosting:
1. Upload seluruh folder ini ke level di bawah `public_html` (misal di folder `/home/username/demakijo1-konversi/`).
2. Buat **Symlink** atau pindahkan seluruh isi folder `public/` ke dalam `public_html`.
3. Buka file `index.php` yang sudah ada di `public_html`, lalu sesuaikan *path* ke file autoloader:
   ```php
   require __DIR__ . '/../demakijo1-konversi/vendor/autoload.php';
   ```

### VPS Server (Nginx)
Arahkan *Document Root* web server langsung ke direktori `public/`.
```nginx
server {
    listen 80;
    server_name namadomain.com;
    root /var/www/demakijo1-konversi/public;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }
}
```

---
*Blueprint arsitektur ini disusun untuk memenuhi kebutuhan maintenance jangka panjang yang cepat dan efisien. Jika Anda menemukan bug atau masalah, silakan buat issue baru!*