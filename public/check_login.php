<?php
/**
 * Script Diagnostik Login & Reset Password
 * HAPUS file ini setelah digunakan!
 * 
 * Akses: https://demakijo1.mediacomptech.com/check_login.php
 */

// Keamanan: Hanya bisa diakses dengan token rahasia
$SECRET_TOKEN = 'demakijo2026fix';
$token = $_GET['token'] ?? '';

if ($token !== $SECRET_TOKEN) {
    http_response_code(403);
    die('<h1>403 Forbidden</h1><p>Akses ditolak. Tambahkan ?token=demakijo2026fix di URL.</p>');
}

require __DIR__ . '/../vendor/autoload.php';
\App\Core\App::boot();

use Illuminate\Database\Capsule\Manager as Capsule;

$action = $_GET['action'] ?? 'info';
$newPassword = $_GET['newpass'] ?? 'DemakijoAdmin2026!';
$newEmail    = $_GET['email']   ?? 'admin@sdndemakijo1.sch.id'; // Email sesuai data di DB

?><!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Diagnostik Login - SDN Demakijo 1</title>
<style>
body { font-family: monospace; padding: 20px; background: #1a1a2e; color: #e0e0e0; }
h1 { color: #38b6ff; }
h2 { color: #ffde59; }
.box { background: #16213e; border: 1px solid #0f3460; padding: 15px; border-radius: 8px; margin: 15px 0; }
.ok { color: #4caf50; }
.err { color: #f44336; }
.warn { color: #ff9800; }
pre { background: #0f0f23; padding: 10px; border-radius: 4px; overflow-x: auto; }
a { color: #38b6ff; }
.btn { display: inline-block; padding: 10px 20px; background: #004aad; color: white; text-decoration: none; border-radius: 5px; margin: 5px; }
.btn-danger { background: #c62828; }
.btn-success { background: #2e7d32; }
</style>
</head>
<body>
<h1>🔍 Diagnostik Login SDN Demakijo 1</h1>
<div class="box">
<strong class="err">⚠️ PERINGATAN: Hapus file ini setelah selesai digunakan!</strong><br>
Path: <code>/public/check_login.php</code>
</div>

<?php

// ---- CEK KONEKSI DATABASE ----
echo '<div class="box"><h2>1. Status Koneksi Database</h2>';
try {
    $pdo = Capsule::connection()->getPdo();
    echo '<p class="ok">✅ Database terhubung: <code>' . ($_ENV['DB_DATABASE'] ?? '?') . '</code> @ <code>' . ($_ENV['DB_HOST'] ?? '?') . '</code></p>';
} catch (\Exception $e) {
    echo '<p class="err">❌ Gagal koneksi: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '</div></body></html>';
    exit;
}
echo '</div>';

// ---- DAFTAR SEMUA USER ----
echo '<div class="box"><h2>2. Data User di Database</h2>';
try {
    $users = Capsule::table('users')->get();
    if ($users->isEmpty()) {
        echo '<p class="warn">⚠️ Tabel users KOSONG! Tidak ada user yang bisa login.</p>';
    } else {
        echo '<table border="1" cellpadding="8" style="border-collapse:collapse; width:100%;">';
        echo '<tr style="background:#0f3460;"><th>ID</th><th>Name</th><th>Email</th><th>Password Hash</th><th>Created</th></tr>';
        foreach ($users as $user) {
            $hashInfo = password_get_info($user->password ?? '');
            $hashStatus = ($hashInfo['algo'] && $hashInfo['algo'] !== 0) 
                ? '<span class="ok">✅ bcrypt</span>' 
                : '<span class="err">❌ Tidak di-hash (plain text!)</span>';
            echo '<tr>';
            echo '<td>' . $user->id . '</td>';
            echo '<td>' . htmlspecialchars($user->name ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($user->email ?? '') . '</td>';
            echo '<td>' . $hashStatus . '<br><small>' . substr($user->password ?? '', 0, 20) . '...</small></td>';
            echo '<td>' . ($user->created_at ?? '-') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
} catch (\Exception $e) {
    echo '<p class="err">❌ Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
echo '</div>';

// ---- TEST PASSWORD_VERIFY ----
if (isset($_GET['test_email']) && isset($_GET['test_pass'])) {
    $testEmail = $_GET['test_email'];
    $testPass  = $_GET['test_pass'];
    echo '<div class="box"><h2>3. Test Verifikasi Password</h2>';
    $user = Capsule::table('users')->where('email', $testEmail)->first();
    if (!$user) {
        echo '<p class="err">❌ User dengan email ' . htmlspecialchars($testEmail) . ' tidak ditemukan!</p>';
    } else {
        $result = password_verify($testPass, $user->password);
        if ($result) {
            echo '<p class="ok">✅ Password COCOK! Login seharusnya BERHASIL.</p>';
        } else {
            echo '<p class="err">❌ Password TIDAK COCOK.</p>';
            $info = password_get_info($user->password);
            echo '<pre>Hash info: ' . print_r($info, true) . '</pre>';
            echo '<p>Hash di DB: <code>' . htmlspecialchars($user->password) . '</code></p>';
        }
    }
    echo '</div>';
}

// ---- BUAT / RESET USER ADMIN ----
if ($action === 'reset' || $action === 'create') {
    echo '<div class="box"><h2>4. Reset / Buat User Admin</h2>';
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    
    try {
        $existing = Capsule::table('users')->where('email', $newEmail)->first();
        if ($existing) {
            Capsule::table('users')->where('email', $newEmail)->update([
                'password'   => $hashedPassword,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            echo '<p class="ok">✅ Password untuk <strong>' . htmlspecialchars($newEmail) . '</strong> berhasil direset!</p>';
        } else {
            Capsule::table('users')->insert([
                'name'       => 'Admin SDN Demakijo 1',
                'email'      => $newEmail,
                'password'   => $hashedPassword,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            echo '<p class="ok">✅ User admin baru berhasil dibuat!</p>';
        }
        echo '<table border="1" cellpadding="8" style="border-collapse:collapse;">';
        echo '<tr><td>Email</td><td><strong>' . htmlspecialchars($newEmail) . '</strong></td></tr>';
        echo '<tr><td>Password</td><td><strong>' . htmlspecialchars($newPassword) . '</strong></td></tr>';
        echo '<tr><td>Hash</td><td><small>' . htmlspecialchars($hashedPassword) . '</small></td></tr>';
        echo '</table>';
        echo '<p class="warn">⚠️ Catat kredensial di atas, lalu <strong>hapus file ini segera!</strong></p>';
    } catch (\Exception $e) {
        echo '<p class="err">❌ Gagal: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    echo '</div>';
}

?>

<div class="box">
<h2>🛠️ Aksi Tersedia</h2>

<h3>Test Login:</h3>
<form method="get" action="">
<input type="hidden" name="token" value="<?= htmlspecialchars($SECRET_TOKEN) ?>">
<input type="hidden" name="action" value="info">
<label>Email: <input type="text" name="test_email" value="admin@sdndemakijo1.sch.id" style="background:#0f0f23;color:#fff;border:1px solid #333;padding:5px; width:280px;"></label><br><br>
<label>Password: <input type="text" name="test_pass" value="" style="background:#0f0f23;color:#fff;border:1px solid #333;padding:5px; width:280px;" placeholder="Test password di sini"></label><br><br>
<button type="submit" class="btn">🔍 Test Verifikasi Password</button>
</form>

<h3>Reset Password — Pilih akun yang ada di DB:</h3>
<p class="warn">⚠️ Email di database: <strong>admin@sdndemakijo1.sch.id</strong> dan <strong>operator@sdndemakijo1.sch.id</strong></p>
<a href="?token=<?= $SECRET_TOKEN ?>&action=reset&email=admin@sdndemakijo1.sch.id&newpass=DemakijoAdmin2026!" class="btn btn-danger">
🔑 Reset: admin@sdndemakijo1.sch.id → DemakijoAdmin2026!
</a><br><br>
<a href="?token=<?= $SECRET_TOKEN ?>&action=reset&email=operator@sdndemakijo1.sch.id&newpass=DemakijoAdmin2026!" class="btn btn-danger">
🔑 Reset: operator@sdndemakijo1.sch.id → DemakijoAdmin2026!
</a><br><br>
<a href="?token=<?= $SECRET_TOKEN ?>&action=create&email=admin@sdndemakijo1.sch.id&newpass=DemakijoAdmin2026!" class="btn btn-success">
➕ Buat User Admin Baru (jika belum ada)
</a>
</div>

<div class="box">
<p class="err"><strong>🗑️ SETELAH SELESAI: Hapus file ini via File Manager cPanel!</strong></p>
<code>/home/medh1179/public_html/demakijo1/public/check_login.php</code>
</div>

</body>
</html>
