<?php
// clear_cache.php - Clean all caches (Blade views) and fix folder permissions
header("Content-Type: text/html");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$log = [];
$error = false;

// 1. Clear BladeOne Cache
$cacheDir = __DIR__ . '/../storage/cache';
if (is_dir($cacheDir)) {
    $files = glob($cacheDir . '/*.{php,bladec}', GLOB_BRACE);
    $deletedCount = 0;
    foreach ($files as $file) {
        if (is_file($file) && basename($file) !== '.gitkeep') {
            if (@unlink($file)) {
                $deletedCount++;
            }
        }
    }
    $log[] = "✓ Berhasil menghapus <b>$deletedCount</b> file compiled view cache di <code>storage/cache/</code>.";
} else {
    $log[] = "ℹ Folder <code>storage/cache/</code> tidak ditemukan.";
}

// 2. Fix permissions of public/storage
$storageDir = __DIR__ . '/storage';
if (is_dir($storageDir)) {
    $currentPerms = fileperms($storageDir) & 0777;
    if ($currentPerms !== 0755) {
        if (@chmod($storageDir, 0755)) {
            $log[] = "✓ Berhasil mengubah permission <code>public/storage</code> menjadi <b>0755</b>.";
        } else {
            $log[] = "❌ Gagal mengubah permission <code>public/storage</code> (Permission saat ini: " . sprintf('%o', $currentPerms) . ").";
            $error = true;
        }
    } else {
        $log[] = "✓ Folder <code>public/storage</code> sudah memiliki permission <b>0755</b>.";
    }

    // Also fix uploads directory
    $uploadsDir = $storageDir . '/uploads';
    if (is_dir($uploadsDir)) {
        $uploadsPerms = fileperms($uploadsDir) & 0777;
        if ($uploadsPerms !== 0755) {
            if (@chmod($uploadsDir, 0755)) {
                $log[] = "✓ Berhasil mengubah permission <code>public/storage/uploads</code> menjadi <b>0755</b>.";
            }
        } else {
            $log[] = "✓ Folder <code>public/storage/uploads</code> sudah memiliki permission <b>0755</b>.";
        }
    } else {
        if (@mkdir($uploadsDir, 0755, true)) {
            $log[] = "✓ Folder <code>public/storage/uploads</code> belum ada dan berhasil dibuat dengan permission <b>0755</b>.";
        }
    }
} else {
    if (@mkdir($storageDir, 0755, true)) {
        $log[] = "✓ Folder <code>public/storage</code> belum ada dan berhasil dibuat dengan permission <b>0755</b>.";
        @mkdir($storageDir . '/uploads', 0755, true);
    } else {
        $log[] = "❌ Folder <code>public/storage</code> tidak ditemukan dan gagal dibuat otomatis.";
        $error = true;
    }
}

// 3. Clear OPcache
if (function_exists('opcache_reset')) {
    if (opcache_reset()) {
        $log[] = "✓ Berhasil mereset OPcache server.";
    } else {
        $log[] = "ℹ OPcache ada tetapi gagal direset (mungkin tidak diijinkan oleh hosting).";
    }
} else {
    $log[] = "ℹ OPcache tidak aktif atau tidak diijinkan di server hosting ini.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cache & Permission Cleaner</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; padding: 30px; background: #f8fafc; color: #334155; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); max-width: 650px; margin: 0 auto; }
        h2 { color: #1e3a8a; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; margin-top: 0; }
        ul { padding-left: 20px; line-height: 1.6; }
        li { margin-bottom: 10px; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; margin-top: 15px; }
        .btn:hover { background: #1d4ed8; }
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
            <div class="alert success">✓ Semua proses selesai dengan sukses!</div>
        <?php else: ?>
            <div class="alert warning">⚠️ Beberapa proses mengalami kendala, cek detail di atas.</div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 25px;">
            <a href="/admin/berita" class="btn">Kembali ke Admin</a>
        </div>
    </div>
</body>
</html>
