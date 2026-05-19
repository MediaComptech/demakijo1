# Arsitektur Native PHP MVC

Aplikasi ini menggunakan pola arsitektur **Model-View-Controller (MVC)** yang dirancang dari nol tanpa bergantung pada full-stack framework seperti Laravel atau CodeIgniter. Tujuan utamanya adalah mengurangi "magic code" sehingga seluruh alur eksekusi lebih mudah ditelusuri (*traceable*).

## 1. Siklus Permintaan (Request Lifecycle)

1. **`public/index.php`**: Entry point untuk semua request. Di sini composer autoloader dimuat, dan aplikasi di-bootstrap melalui `App\Core\App::boot()`.
2. **`app/Core/App.php`**: Menginisialisasi session, membaca konfigurasi dari `.env`, mengatur koneksi database (Standalone Eloquent), dan menyetel engine template (BladeOne).
3. **`routes/web.php`**: Menerima URI yang diminta, lalu mencocokkannya dengan daftar rute yang ada. Jika cocok, router akan memanggil Controller dan Method yang sesuai.
4. **Controller (`app/Controllers/`)**: Menjalankan logika bisnis. Dapat berinteraksi dengan **Model** untuk mengambil data dari database.
5. **Model (`app/Models/`)**: Merepresentasikan struktur tabel di database menggunakan fitur ORM (Object-Relational Mapping) dari Eloquent.
6. **View (`app/Views/`)**: Controller mengembalikan View hasil render BladeOne (`App\Core\View::render()`) kepada pengguna.

## 2. Struktur Direktori Utama

- **`app/Core/`**: Jantung dari framework kustom ini. Berisi komponen seperti Router, Request, Security, Session, Validator, View, dan facade-facade pendukung.
- **`app/Controllers/`**: Tempat menyimpan seluruh kelas controller. Terbagi menjadi controller untuk sisi publik dan backend (admin).
- **`app/Models/`**: Berisi seluruh file Model Eloquent.
- **`app/Views/`**: File-file template menggunakan sintaks Blade (`.blade.php`).
- **`config/`**: Konfigurasi statis aplikasi (seperti database dan app setting).
- **`public/`**: Direktori yang bisa diakses langsung dari internet. Berisi aset (CSS/JS/images) dan `index.php`.
- **`routes/`**: Tempat mendefinisikan URL routing aplikasi (`web.php`).
- **`storage/`**: Tempat menyimpan file log, cache view, dan file upload.

## 3. Komponen Utama

### Standalone Eloquent
Aplikasi tetap menggunakan fitur ORM dari Laravel yang kuat. Cara menggunakannya sama persis seperti di Laravel.

```php
$berita = App\Models\Berita::where('is_published', true)->orderBy('created_at', 'desc')->get();
```

### BladeOne Template Engine
Mendukung semua sintaks dasar Blade Laravel, termasuk template inheritance (`@extends`, `@section`, `@yield`), perulangan (`@foreach`), pengkondisian (`@if`), dan komponen lainnya.

### Security
Semua request POST, PUT, dan DELETE dilindungi oleh sistem token CSRF kustom. Token ini harus disertakan di setiap form POST menggunakan fungsi pembantu `csrf_field()`.

### Session & Auth
Manajemen login tidak lagi menggunakan facade `Auth` bawaan Laravel, melainkan menggunakan `App\Core\Auth` yang menangani enkripsi, pengecekan role, dan pemeliharaan status login.
