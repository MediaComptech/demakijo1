# Maintenance Status - SDN Demakijo 1

## Plan 1 — Selesai (DONE)
* [x] Cek fungsi menu CRUD Admin dan fix error nya (Semua controller telah menggunakan `unique_slug()` dan perbaikan nullable unique `nisn`)
* [x] Pastikan aplikasi berjalan dengan baik (Global error/exception handling di Router menangkap error database dengan anggun dan memberi flash error)
* [x] Cek responsif web nya dan fix jika ada yg perlu di perbaiki (AdminLTE dan Bootstrap 5 layout sudah mendukung responsive viewport)
* [x] PWA bisa diinstall dan berjalan dengan baik (Aset `manifest.json`, `service-worker.js` dan PWA icons terpasang, registrasi terintegrasi di main layout)

## Plan 2 — Sedang Berjalan (IN PROGRESS)
* [x] Push Github https://github.com/MediaComptech/demakijo1_deploy
* [/] Pull Cpanel https://cpanel.sdndemakijo1.sch.id (jalankan migrate_add_role_to_users.php via terminal cPanel)
* [x] Update Readme.md
* [x] Update PRD.md
* [x] Update maintenance.md
* [x] Update CHANGELOG.md
* [x] Cek CRUD user admin dan operator — FIXED (tambah role field, validasi email unik, form create/edit/index)
* [x] Cek CRUD berita — OK (unique_slug sudah aktif)
* [x] Cek CRUD pengumuman — OK (slug + user_id sudah diperbaiki)
* [x] Cek CRUD fasilitas — OK (unique_slug sudah aktif)
* [x] Cek CRUD keunggulan — OK (tidak ada unique constraint bermasalah)
* [x] Cek CRUD siswa — OK (nisn → null sudah ditangani)
* [x] Cek CRUD alumni — OK (tidak ada unique constraint)
* [x] Cek CRUD ppdb — OK (backend admin ok; publik FIXED response()->json() dan redirect)
* [x] Cek menu front end — OK (rute publik terdefinisi lengkap)
* [x] Cek menu back end — OK (sidebar AdminLTE lengkap)
* [x] Cek Database CRUD — OK (35 tabel, koneksi DB berhasil)
* [x] Perbaiki eror CRUD user admin dan operator — FIXED
* [x] Perbaiki Validator (tambah rule: string, max, digits, unique, in, date)
* [x] Perbaiki GuruController (NIP kosong → null)