<?php
/**
 * RESET PASSWORD - SDN Demakijo 1
 * ================================
 * Akses: https://demakijo1.mediacomptech.com/reset_pass.php?token=demakijo2026reset
 * 
 * Script ini langsung update password semua admin di database.
 * HAPUS file ini setelah digunakan!
 */

$SECRET = 'demakijo2026reset';
if (($_GET['token'] ?? '') !== $SECRET) {
    http_response_code(403);
    die('<h1>403</h1><p>Tambahkan: <code>?token=demakijo2026reset</code></p>');
}

$NEW_PASSWORD = 'DemakijoAdmin2026!';
// Hash yang sudah diverifikasi cocok dengan password_verify()
$HASH = '$2y$10$A5AEu/oyResaCxyYRfJZf.1bbpNQk.WRcY/Iu4ljGNEADosrI8HPW';

// Verifikasi hash sebelum digunakan
if (!password_verify($NEW_PASSWORD, $HASH)) {
    die('<p style="color:red">❌ HASH TIDAK VALID! Hubungi developer.</p>');
}

require __DIR__ . '/../vendor/autoload.php';
\App\Core\App::boot();

use Illuminate\Database\Capsule\Manager as Capsule;

?><!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Reset Password - SDN Demakijo 1</title>
<style>
* { box-sizing: border-box; }
body { font-family: monospace; background: #0d1117; color: #c9d1d9; padding: 30px; margin: 0; }
h1 { color: #58a6ff; border-bottom: 1px solid #30363d; padding-bottom: 10px; }
.box { background: #161b22; border: 1px solid #30363d; border-radius: 8px; padding: 20px; margin: 16px 0; }
.ok  { color: #3fb950; font-weight: bold; }
.err { color: #f85149; font-weight: bold; }
.warn { color: #d29922; }
table { border-collapse: collapse; width: 100%; }
td, th { border: 1px solid #30363d; padding: 8px 12px; text-align: left; }
th { background: #21262d; color: #58a6ff; }
code { background: #21262d; padding: 2px 6px; border-radius: 4px; font-size: 0.85em; }
.btn { display: inline-block; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; margin: 5px; cursor: pointer; border: none; font-size: 1rem; }
.btn-blue { background: #1f6feb; color: white; }
.btn-red { background: #da3633; color: white; }
.alert { border-left: 4px solid #d29922; background: #272115; padding: 12px 16px; border-radius: 0 6px 6px 0; color: #d29922; }
</style>
</head>
<body>
<h1>🔧 Reset Password SDN Demakijo 1</h1>
<div class="box alert">
    ⚠️ <strong>HAPUS file ini setelah selesai!</strong>
    Path: <code>/public/reset_pass.php</code>
</div>

<?php

// ===== CEK KONEKSI DB =====
echo '<div class="box"><h3>1. Koneksi Database</h3>';
try {
    Capsule::connection()->getPdo();
    echo '<p class="ok">✅ Terhubung ke: ' . ($_ENV['DB_DATABASE'] ?? '?') . '</p>';
} catch (\Exception $e) {
    echo '<p class="err">❌ Gagal: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '</div></body></html>'; exit;
}
echo '</div>';

// ===== TAMPILKAN USER =====
echo '<div class="box"><h3>2. Data User Saat Ini</h3>';
$users = Capsule::table('users')->get();
echo '<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Hash Status</th><th>Updated</th></tr>';
foreach ($users as $u) {
    $info = password_get_info($u->password ?? '');
    $hashOk = $info['algo'] && $info['algo'] !== 0;
    $canLogin = password_verify($NEW_PASSWORD, $u->password ?? '');
    echo '<tr>';
    echo '<td>' . $u->id . '</td>';
    echo '<td>' . htmlspecialchars($u->name ?? '') . '</td>';
    echo '<td>' . htmlspecialchars($u->email ?? '') . '</td>';
    echo '<td>'
        . ($hashOk ? '<span class="ok">✅ bcrypt</span>' : '<span class="err">❌ plain/invalid</span>')
        . ' | Password DemakijoAdmin2026!: '
        . ($canLogin ? '<span class="ok">✅ COCOK</span>' : '<span class="err">❌ TIDAK COCOK</span>')
        . '</td>';
    echo '<td>' . ($u->updated_at ?? '-') . '</td>';
    echo '</tr>';
}
echo '</table></div>';

// ===== EKSEKUSI RESET =====
$doReset = isset($_GET['reset']) && $_GET['reset'] === 'yes';

if ($doReset) {
    echo '<div class="box"><h3>3. Hasil Reset Password</h3>';
    $now = date('Y-m-d H:i:s');
    $updated = 0;
    try {
        // Update SEMUA user sekaligus
        $updated = Capsule::table('users')->update([
            'password'   => $HASH,
            'updated_at' => $now,
        ]);
        echo '<p class="ok">✅ ' . $updated . ' user berhasil di-reset!</p>';
        echo '<table>';
        echo '<tr><th>Field</th><th>Nilai</th></tr>';
        echo '<tr><td>Password Baru</td><td><strong>' . $NEW_PASSWORD . '</strong></td></tr>';
        echo '<tr><td>Hash</td><td><code style="font-size:0.75em;">' . $HASH . '</code></td></tr>';
        echo '<tr><td>Verifikasi Hash</td><td class="ok">✅ VALID (password_verify = true)</td></tr>';
        echo '</table>';
        echo '<p class="warn" style="margin-top:12px;">⚠️ SEGERA HAPUS file ini setelah login berhasil!</p>';
    } catch (\Exception $e) {
        echo '<p class="err">❌ Gagal: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    echo '</div>';

    // Tampilkan user sesudah reset
    echo '<div class="box"><h3>4. Verifikasi Sesudah Reset</h3>';
    $users2 = Capsule::table('users')->get();
    echo '<table><tr><th>ID</th><th>Email</th><th>Password DemakijoAdmin2026!</th></tr>';
    foreach ($users2 as $u) {
        $ok = password_verify($NEW_PASSWORD, $u->password ?? '');
        echo '<tr>';
        echo '<td>' . $u->id . '</td>';
        echo '<td>' . htmlspecialchars($u->email ?? '') . '</td>';
        echo '<td>' . ($ok ? '<span class="ok">✅ BERHASIL - Siap Login</span>' : '<span class="err">❌ MASIH GAGAL</span>') . '</td>';
        echo '</tr>';
    }
    echo '</table></div>';
}

?>

<div class="box">
    <h3>🎯 Aksi</h3>
    <?php if (!$doReset): ?>
    <p>Klik tombol di bawah untuk mereset password <strong>semua user</strong> menjadi:</p>
    <table>
        <tr><td>Password</td><td><strong style="color:#3fb950; font-size:1.1em;"><?= $NEW_PASSWORD ?></strong></td></tr>
        <tr><td>Berlaku untuk</td><td>admin@sdndemakijo1.sch.id, operator@sdndemakijo1.sch.id, dan user lainnya</td></tr>
    </table>
    <br>
    <a href="?token=<?= $SECRET ?>&reset=yes" class="btn btn-red" onclick="return confirm('Reset password semua user?')">
        🔑 RESET PASSWORD SEMUA USER → DemakijoAdmin2026!
    </a>
    <?php else: ?>
    <p class="ok">✅ Reset selesai! Coba login sekarang:</p>
    <table>
        <tr><td>URL Login</td><td><a href="https://demakijo1.mediacomptech.com/login" target="_blank" style="color:#58a6ff;">https://demakijo1.mediacomptech.com/login</a></td></tr>
        <tr><td>Email</td><td><strong>admin@sdndemakijo1.sch.id</strong></td></tr>
        <tr><td>Password</td><td><strong style="color:#3fb950;"><?= $NEW_PASSWORD ?></strong></td></tr>
    </table>
    <?php endif; ?>
</div>

<div class="box">
    <h3>💾 SQL Manual (backup — jalankan di phpMyAdmin jika script gagal)</h3>
    <p>Buka <strong>phpMyAdmin → database medh1179_demakijo1 → SQL</strong>, paste query ini:</p>
    <pre style="background:#0d1117; padding:15px; border-radius:6px; border:1px solid #30363d; overflow-x:auto; color:#a5d6ff;">UPDATE `users`
SET `password` = '<?= $HASH ?>',
    `updated_at` = NOW()
WHERE `email` IN (
    'admin@sdndemakijo1.sch.id',
    'operator@sdndemakijo1.sch.id'
);</pre>
    <p class="warn">Hash ini telah diverifikasi: <code>password_verify('DemakijoAdmin2026!', hash) = <strong>true</strong></code></p>
</div>

<div class="box" style="border-color:#da3633;">
    <span class="err">🗑️ WAJIB HAPUS setelah selesai:</span>
    <code>/home/medh1179/public_html/demakijo1/public/reset_pass.php</code>
</div>
</body>
</html>
