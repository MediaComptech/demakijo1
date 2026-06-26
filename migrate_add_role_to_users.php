<?php
/**
 * Migration: Tambah kolom role ke tabel users
 * Jalankan sekali via terminal cPanel: php migrate_add_role_to_users.php
 */

require 'vendor/autoload.php';
\App\Core\App::boot();

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

$schema = Capsule::schema();

// Cek apakah kolom role sudah ada
$columns = Capsule::select("SHOW COLUMNS FROM users LIKE 'role'");

if (!empty($columns)) {
    echo "✅ Kolom 'role' sudah ada di tabel users. Tidak perlu migrasi.\n";
} else {
    $schema->table('users', function (Blueprint $table) {
        $table->string('role', 20)->default('admin')->after('password');
    });
    echo "✅ Kolom 'role' berhasil ditambahkan ke tabel users.\n";
}

// Update user operator agar memiliki role 'operator'
$updated = Capsule::table('users')
    ->whereIn('email', ['operator@sdndemakijo1.sch.id'])
    ->update(['role' => 'operator']);

echo "✅ {$updated} user operator berhasil diset role 'operator'.\n";

// Tampilkan semua user
$users = Capsule::table('users')->get();
echo "\nDaftar User saat ini:\n";
foreach ($users as $u) {
    echo "  - ID:{$u->id} | {$u->name} | {$u->email} | role: " . ($u->role ?? 'belum diset') . "\n";
}
echo "\nSelesai.\n";
