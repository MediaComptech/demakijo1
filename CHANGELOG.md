# Changelog - SDN Demakijo 1

Semua perubahan penting pada proyek sistem informasi sekolah SDN Demakijo 1 didokumentasikan di sini.

## [2026-06-26]

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
