<?php
// clear_cache.php - Clean all compiled view caches and fix folder permissions
header("Content-Type: text/html");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$log = [];
$error = false;

// 1. Clear ALL BladeOne Compiled View Cache using scandir (robust, works on all servers)
$cacheDir = __DIR__ . '/../storage/cache';
if (is_dir($cacheDir)) {
    $deletedCount  = 0;
    $failedCount   = 0;
    $allCacheFiles = scandir($cacheDir);
    foreach ($allCacheFiles as $file) {
        if ($file === '.' || $file === '..' || $file === '.gitkeep') continue;
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (!in_array($ext, ['php', 'bladec', ''])) continue; // only cache files
        $fullPath = $cacheDir . '/' . $file;
        if (is_file($fullPath)) {
            if (@unlink($fullPath)) {
                $deletedCount++;
            } else {
                $failedCount++;
            }
        }
    }
    if ($failedCount > 0) {
        $log[] = "⚠️ Berhasil menghapus <b>$deletedCount</b> file cache, <b>$failedCount</b> file gagal dihapus (permission issue).";
        $error = true;
    } else {
        $log[] = "✓ Berhasil menghapus <b>$deletedCount</b> file compiled view cache di <code>storage/cache/</code>.";
    }
} else {
    $log[] = "ℹ Folder <code>storage/cache/</code> tidak ditemukan. Membuat folder...";
    if (@mkdir($cacheDir, 0755, true)) {
        $log[] = "✓ Folder <code>storage/cache/</code> berhasil dibuat.";
    }
}

// 2. Fix permissions of public/storage and public/storage/uploads
$storageDir = __DIR__ . '/storage';
if (is_dir($storageDir)) {
    @chmod($storageDir, 0755);
    $currentPerms = fileperms($storageDir) & 0777;
    if ($currentPerms === 0755) {
        $log[] = "✓ Folder <code>public/storage</code> sudah memiliki permission <b>0755</b>.";
    } else {
        $log[] = "❌ Gagal mengatur permission <code>public/storage</code> (Permission saat ini: " . sprintf('%o', $currentPerms) . ").";
        $error = true;
    }

    // Also fix uploads directory
    $uploadsDir = $storageDir . '/uploads';
    if (!is_dir($uploadsDir)) {
        @mkdir($uploadsDir, 0755, true);
    }
    @chmod($uploadsDir, 0755);
    $uploadsPerms = fileperms($uploadsDir) & 0777;
    if ($uploadsPerms === 0755) {
        $log[] = "✓ Folder <code>public/storage/uploads</code> sudah memiliki permission <b>0755</b>.";
    } else {
        $log[] = "❌ Gagal mengatur permission <code>public/storage/uploads</code>.";
        $error = true;
    }
} else {
    if (@mkdir($storageDir . '/uploads', 0755, true)) {
        $log[] = "✓ Folder <code>public/storage/uploads</code> berhasil dibuat dengan permission <b>0755</b>.";
    } else {
        $log[] = "❌ Folder <code>public/storage</code> tidak ditemukan dan gagal dibuat otomatis.";
        $error = true;
    }
}

// 3. Check .env APP_ENV and report BladeOne mode
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    preg_match('/^APP_ENV\s*=\s*(.+)$/m', $envContent, $matches);
    $appEnv = trim($matches[1] ?? 'unknown');
    $bladeMode = ($appEnv === 'production') ? 'MODE_AUTO (cache tidak diperbarui otomatis)' : 'MODE_DEBUG (selalu compile ulang dari source)';
    $log[] = "ℹ <code>APP_ENV=$appEnv</code> → BladeOne mode: <b>$bladeMode</b>. Cache sudah dibersihkan, halaman akan di-compile ulang saat diakses berikutnya.";
} 

// 4. Clear OPcache
if (function_exists('opcache_reset')) {
    if (opcache_reset()) {
        $log[] = "✓ Berhasil mereset OPcache server.";
    } else {
        $log[] = "ℹ OPcache ada tetapi gagal direset (mungkin tidak diijinkan oleh hosting).";
    }
} else {
    $log[] = "ℹ OPcache tidak aktif atau tidak diijinkan di server hosting ini.";
}

// 5. Show remaining cache count
if (is_dir($cacheDir)) {
    $remaining = count(array_filter(scandir($cacheDir), fn($f) => !in_array($f, ['.', '..', '.gitkeep'])));
    $log[] = "ℹ Sisa file di <code>storage/cache/</code> setelah pembersihan: <b>$remaining</b> file.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cache & Permission Cleaner</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; padding: 30px; background: #f8fafc; color: #334155; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); max-width: 700px; margin: 0 auto; }
        h2 { color: #1e3a8a; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; margin-top: 0; }
        ul { padding-left: 20px; line-height: 1.8; }
        li { margin-bottom: 8px; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 15px; margin-right: 8px; }
        .btn:hover { background: #1d4ed8; }
        .btn-green { background: #16a34a; }
        .btn-green:hover { background: #15803d; }
        .alert { padding: 10px 15px; border-radius: 6px; font-weight: bold; margin-top: 15px; }
        .success { background: #dcfce7; color: #15803d; }
        .warning { background: #fef3c7; color: #d97706; }
    </style>
</head>
<body>
    <div class="card">
        <h2>System Cache & Permission Cleaner</h2>
        <p>Proses pembersihan cache dan perbaikan hak akses folder:</p>
        
        <ul>
            <?php foreach ($log as $item): ?>
                <li><?php echo $item; ?></li>
            <?php endforeach; ?>
        </ul>
        
        <?php if (!$error): ?>
            <div class="alert success">✓ Semua proses selesai dengan sukses! Buka halaman admin untuk melihat tampilan terbaru.</div>
        <?php else: ?>
            <div class="alert warning">⚠️ Beberapa proses mengalami kendala, cek detail di atas.</div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 25px;">
            <a href="/admin/berita" class="btn">Ke Halaman Berita</a>
            <a href="/admin/pengaturan" class="btn btn-green">Ke Pengaturan</a>
        </div>
    </div>
</body>
</html>
