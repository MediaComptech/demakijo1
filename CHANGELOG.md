# Changelog - SDN Demakijo 1

Semua perubahan penting pada proyek sistem informasi sekolah SDN Demakijo 1 didokumentasikan di sini.

## [2026-06-26] Plan 2 Fix

### Fixed
- **Validator.php**: Ditambah dukungan rule `string`, `max:N`, `digits:N`, `unique:table[,col]`, `in:a,b,c`, dan `date`. Sebelumnya semua rule ini dipakai di `PpdbPublikController` tapi tidak diimplementasikan, menyebabkan validasi PPDB tidak berfungsi sama sekali.
- **Request.php**: Method `validate()` diperbaiki agar mendukung argumen kedua berupa custom error messages — konsisten dengan signature Laravel.
- **PpdbPublikController.php**: Ganti `response()->json()` (tidak ada di framework ini) dengan `json_encode` native PHP + header `Content-Type: application/json`. Perbaiki `redirect('ppdb.form')` → `redirect('/ppdb-online')`.
- **UserController.php**: (a) Tambah validasi email unik saat create; (b) Ambil password langsung dari `$_POST` agar karakter spesial seperti `!@#` tidak di-escape oleh `htmlspecialchars`; (c) Gunakan `header() + exit` langsung agar tidak ada masalah timing dengan destructor redirect.
- **User.php (Model)**: Tambah field `role` ke `$fillable` agar mass assignment saat buat/ubah user menyimpan role.
- **GuruController.php**: Tambah konversi NIP kosong `''` ke `null` di `store()` dan `update()` agar tidak terjadi pelanggaran UNIQUE constraint ketika dua guru tidak memiliki NIP.

### Added
- **user/create.blade.php**: Tambah field select `role` (Admin/Operator/Super Admin) dengan tampilan form yang lebih lengkap.
- **user/edit.blade.php**: Tambah field select `role` dengan proteksi disabled untuk Super Admin (ID 1).
- **user/index.blade.php**: Tambah kolom Role dengan badge berwarna (Super Admin=merah, Operator=biru, Admin=biru gelap).
- **migrate_add_role_to_users.php**: Script migrasi untuk menambah kolom `role VARCHAR(20) DEFAULT 'admin'` ke tabel `users` di server hosting. Jalankan sekali via terminal cPanel: `php migrate_add_role_to_users.php`.



### Added
- Fungsi helper `unique_slug()` di `app/Helpers/GlobalHelper.php` untuk menghasilkan slug unik secara otomatis berdasarkan model Eloquent dengan menghindari tabrakan data (collision) menggunakan suffix angka (misal: `-1`, `-2`, dst).
- Global catch block di `app/Core/Router.php` untuk menangani `QueryException` (kesalahan database) dan `Throwable` umum. Error dari database secara otomatis ditangkap, dicatat ke log, dan pengguna diarahkan kembali ke halaman sebelumnya dengan flash notification yang ramah pengguna.
- File konfigurasi PWA `manifest.json` dan `service-worker.js` di folder `public` beserta aset ikon PWA (`logo-192.png` dan `logo-512.png`).
- Integrasi PWA di layout frontend publik (`app/Views/publik/layout.blade.php`) dengan menyertakan tag `<link rel="manifest">`, meta tags iOS, dan skrip registrasi service worker.

### Fixed
- Penanganan input kosong (`''`) pada kolom `nisn` dan `nis` di `SiswaController.php` dengan mengubahnya menjadi `null` secara otomatis sebelum proses simpan atau ubah untuk mencegah pelanggaran konstrain kunci unik (`UNIQUE`) di MySQL.
- Pembaruan semua controller backend admin berikut agar menggunakan `unique_slug()` untuk menjamin keunikan slug secara otomatis saat proses tambah (`store`) dan ubah (`update`):
  - `BeritaController.php`
  - `AgendaController.php`
  - `AlbumController.php`
  - `PengumumanController.php`
  - `PrestasiController.php`
  - `EkstrakurikulerController.php`
  - `FasilitasController.php`
  - `KategoriBeritaController.php`
- Penanganan `user_id` di `PengumumanController.php` agar secara otomatis mengambil ID user yang sedang login via `auth()->id()` dengan fallback ke `1` jika sesi tidak ditemukan, menyelesaikan kendala input gagal karena field `user_id` yang bernilai `null` pada kolom non-nullable.
- Memastikan kembalinya respon redirect atau status headers yang benar.
