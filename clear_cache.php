<?php
/**
 * CACHE CLEAR SCRIPT - SDN Demakijo 1
 * 
 * Upload ke: /home/sdnc1967/public_html/clear_cache.php
 * Akses via: https://sdndemakijo1.sch.id/clear_cache.php?token=sdndemakijo2026
 * 
 * HAPUS setelah selesai!
 */

$SECRET_TOKEN = 'sdndemakijo2026';
if (!isset($_GET['token']) || $_GET['token'] !== $SECRET_TOKEN) {
    http_response_code(403);
    die('403 Forbidden');
}

header('Content-Type: text/html; charset=utf-8');
$PUBLIC_HTML = '/home/sdnc1967/public_html';

echo '<!DOCTYPE html><html><head><meta charset="utf-8">';
echo '<style>body{font-family:monospace;max-width:800px;margin:30px auto;padding:20px;background:#111;color:#0f0;}';
echo 'h2{color:#ff0;} .ok{color:#0f0;} .err{color:#f44;} .info{color:#ff0;}</style>';
echo '</head><body><h2>🧹 Cache Clear — SDN Demakijo 1</h2><pre>';

$deleted = 0;
$errors  = 0;

// ========================
// 1. HAPUS BLADE CACHE (.bladec files)
// ========================
echo "\n<span class='info'>==== Blade Cache (.bladec) ====</span>\n";
$cacheDir = $PUBLIC_HTML . '/storage/cache';
if (is_dir($cacheDir)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($cacheDir, RecursiveDirectoryIterator::SKIP_DOTS)
    );
    foreach ($iterator as $file) {
        $path = $file->getPathname();
        $name = $file->getFilename();
        if ($name === '.gitkeep') continue;
        if ($file->isFile()) {
            if (@unlink($path)) {
                echo "<span class='ok'>DEL: {$path}</span>\n";
                $deleted++;
            } else {
                echo "<span class='err'>ERR: {$path}</span>\n";
                $errors++;
            }
        }
    }
    echo "Blade cache: {$deleted} file dihapus\n";
} else {
    echo "<span class='err'>Folder cache tidak ditemukan: {$cacheDir}</span>\n";
    // Buat folder
    mkdir($cacheDir, 0755, true);
    echo "<span class='ok'>Folder cache dibuat</span>\n";
}

// ========================
// 2. HAPUS SEMUA FILE .php DI CACHE (compiled views lama)
// ========================
echo "\n<span class='info'>==== Compiled PHP Cache ====</span>\n";
$phpCaches = glob($cacheDir . '/*.php');
$phpCaches2 = glob($cacheDir . '/**/*.php');
$allPhp = array_merge($phpCaches ?: [], $phpCaches2 ?: []);
foreach ($allPhp as $f) {
    if (basename($f) === '.gitkeep') continue;
    if (@unlink($f)) {
        echo "<span class='ok'>DEL: " . basename($f) . "</span>\n";
        $deleted++;
    }
}

// ========================
// 3. PASTIKAN FOLDER ADA DAN WRITABLE
// ========================
echo "\n<span class='info'>==== Folder Check ====</span>\n";
$folders = [
    $PUBLIC_HTML . '/storage',
    $PUBLIC_HTML . '/storage/cache',
    $PUBLIC_HTML . '/public/storage',
    $PUBLIC_HTML . '/public/storage/uploads',
];
foreach ($folders as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "<span class='ok'>MKDIR: {$dir}</span>\n";
    }
    chmod($dir, 0755);
    $writable = is_writable($dir) ? '✅ writable' : '❌ NOT writable';
    echo "PERM: {$dir} — {$writable}\n";
}

// ========================
// 4. CEK .env ADA
// ========================
echo "\n<span class='info'>==== .env Check ====</span>\n";
$envFile = $PUBLIC_HTML . '/.env';
if (file_exists($envFile)) {
    echo "<span class='ok'>.env ADA ✅</span>\n";
    $envContents = file_get_contents($envFile);
    // Tampilkan tanpa password
    $lines = explode("\n", $envContents);
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;
        if (stripos($line, 'PASSWORD') !== false || stripos($line, 'SECRET') !== false) {
            echo htmlspecialchars(explode('=', $line)[0]) . "=***HIDDEN***\n";
        } else {
            echo htmlspecialchars($line) . "\n";
        }
    }
} else {
    echo "<span class='err'>.env TIDAK ADA ❌ — Buat dulu via setup_deploy.php</span>\n";
}

// ========================
// 5. CEK DATABASE CONNECTION
// ========================
echo "\n<span class='info'>==== Database Test ====</span>\n";
if (file_exists($envFile)) {
    $envData = parse_ini_file($envFile);
    try {
        $host = $envData['DB_HOST'] ?? '127.0.0.1';
        $db   = $envData['DB_DATABASE'] ?? '';
        $user = $envData['DB_USERNAME'] ?? '';
        $pass = $envData['DB_PASSWORD'] ?? '';
        $pdo  = new PDO("mysql:host={$host};dbname={$db};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_TIMEOUT => 5,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        echo "<span class='ok'>Koneksi DB berhasil ✅</span>\n";
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "Tabel: " . implode(', ', $tables) . "\n";
    } catch (Exception $e) {
        echo "<span class='err'>Koneksi DB GAGAL ❌: " . htmlspecialchars($e->getMessage()) . "</span>\n";
    }
}

// ========================
// SUMMARY
// ========================
echo "\n<span class='info'>==== SELESAI ====</span>\n";
echo "Total dihapus: {$deleted} file\n";
echo "Error: {$errors}\n";
echo "\n<span class='ok'>Cache berhasil dibersihkan! Coba refresh https://sdndemakijo1.sch.id/</span>\n";
echo "\n<span class='err'>⚠️ HAPUS file clear_cache.php dari public_html setelah selesai!</span>\n";
echo '</pre></body></html>';
