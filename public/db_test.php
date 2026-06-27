<?php
// db_test.php - Temporary database and storage diagnostic
header("Content-Type: text/html");

// Attempt to fix public/storage permissions
$storagePublicDir = __DIR__ . '/storage';
$chmod_status = "";

if (is_dir($storagePublicDir)) {
    $currentPerms = fileperms($storagePublicDir);
    if (($currentPerms & 0777) !== 0755) {
        if (@chmod($storagePublicDir, 0755)) {
            $chmod_status = "<span style='color:green;'>✓ Berhasil mengubah permission public/storage menjadi 0755.</span>";
        } else {
            $chmod_status = "<span style='color:red;'>❌ Gagal mengubah permission public/storage menjadi 0755 (current: " . sprintf('%o', $currentPerms & 0777) . ").</span>";
        }
    } else {
        $chmod_status = "Folder public/storage sudah memiliki permission 0755.";
    }
    
    // Check and fix uploads folder permissions if it exists
    $uploadsDir = $storagePublicDir . '/uploads';
    if (is_dir($uploadsDir)) {
        $uploadsPerms = fileperms($uploadsDir);
        if (($uploadsPerms & 0777) !== 0755) {
            if (@chmod($uploadsDir, 0755)) {
                $chmod_status .= " <span style='color:green;'>✓ Berhasil mengubah permission public/storage/uploads menjadi 0755.</span>";
            }
        }
    }
} else {
    $chmod_status = "Folder public/storage tidak ditemukan, mencoba membuat folder dengan permission 0755...";
    if (@mkdir($storagePublicDir, 0755, true)) {
        $chmod_status .= " <span style='color:green;'>✓ Folder public/storage berhasil dibuat.</span>";
    } else {
        $chmod_status .= " <span style='color:red;'>❌ Gagal membuat folder public/storage.</span>";
    }
}

// Clear OPcache if enabled
if (function_exists('opcache_reset')) {
    opcache_reset();
    $opcache_status = "✓ OPcache berhasil di-reset!";
} else {
    $opcache_status = "OPcache tidak aktif atau tidak diijinkan.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Database & Storage Diagnostic</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f8fafc; color: #334155; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 25px; }
        th, td { border: 1px solid #cbd5e1; padding: 10px; text-align: left; }
        th { background: #e2e8f0; }
        pre { background: #0f172a; color: #38bdf8; padding: 15px; border-radius: 8px; overflow-x: auto; }
        .alert { padding: 10px 15px; border-radius: 6px; margin-bottom: 15px; font-weight: bold; }
        .success { background: #dcfce7; color: #15803d; }
        .error { background: #fee2e2; color: #b91c1c; }
        .info { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
    </style>
</head>
<body>
    <h2>Diagnostic Tool SDN Demakijo 1</h2>
    
    <div class="alert success"><?php echo $opcache_status; ?></div>
    <div class="alert info"><b>Status Permission:</b> <?php echo $chmod_status; ?></div>
    
    <div class="alert info">
        <b>Status Git:</b> 
        <?php
        $gitHeadFile = __DIR__ . '/../.git/refs/heads/main';
        if (file_exists($gitHeadFile)) {
            echo "SHA Commit Teraktif: <code>" . trim(file_get_contents($gitHeadFile)) . "</code>";
        } else {
            echo "Folder .git/refs/heads/main tidak terbaca.";
        }
        ?>
    </div>
    
    <?php
    // Load .env
    $envPath = __DIR__ . '/../.env';
    if (!file_exists($envPath)) {
        echo "<div class='alert error'>Error: File .env tidak ditemukan!</div>";
        exit;
    }
    
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value, " \t\n\r\0\x0B\"'");
        $env[$name] = $value;
    }
    
    // Check storage cache folder
    $cacheDir = __DIR__ . '/../storage/cache';
    echo "<h3>1. Info Folder storage/cache (Blade View Cache)</h3>";
    echo "Path Folder: <code>" . htmlspecialchars($cacheDir) . "</code><br>";
    if (is_dir($cacheDir)) {
        $cacheFiles = array_diff(scandir($cacheDir), ['.', '..']);
        echo "Total file di <code>storage/cache/</code>: <b>" . count($cacheFiles) . "</b><br>";
        if (count($cacheFiles) > 0) {
            echo "<ul>";
            foreach (array_slice($cacheFiles, 0, 20) as $cf) {
                echo "<li>$cf</li>";
            }
            if (count($cacheFiles) > 20) echo "<li>... dan lainnya</li>";
            echo "</ul>";
        }
    } else {
        echo "Status Folder: <b style='color:red;'>Folder storage/cache tidak ditemukan!</b><br>";
    }

    // Check storage paths
    echo "<h3>2. Info Folder Upload/Storage</h3>";
    echo "Path Folder: <code>" . htmlspecialchars($storagePublicDir) . "</code><br>";
    if (is_dir($storagePublicDir)) {
        echo "Status Folder: <b style='color:green;'>Ada (Directory)</b><br>";
        echo "Permissions Terkini: <b>" . substr(sprintf('%o', fileperms($storagePublicDir)), -4) . "</b><br>";
        
        // Scan files inside uploads
        $uploadsDir = $storagePublicDir . '/uploads';
        if (is_dir($uploadsDir)) {
            echo "Status Folder 'uploads': <b style='color:green;'>Ada (Directory)</b><br>";
            echo "Permissions 'uploads' Terkini: <b>" . substr(sprintf('%o', fileperms($uploadsDir)), -4) . "</b><br>";
            
            $files = array_diff(scandir($uploadsDir), ['.', '..']);
            echo "Total File di <code>storage/uploads/</code>: <b>" . count($files) . "</b><br>";
            if (count($files) > 0) {
                echo "<ul>";
                foreach (array_slice($files, 0, 15) as $f) {
                    echo "<li>$f (" . filesize($uploadsDir . '/' . $f) . " bytes)</li>";
                }
                if (count($files) > 15) echo "<li>... dan " . (count($files) - 15) . " file lainnya</li>";
                echo "</ul>";
            }
        } else {
            echo "Status Folder 'uploads': <b style='color:red;'>Belum ada folder 'uploads' di dalam storage.</b><br>";
        }
    } else {
        echo "Status Folder: <b style='color:red;'>Belum ada folder 'storage' di folder public/</b><br>";
    }
    
    try {
        $dsn = "mysql:host=" . ($env['DB_HOST'] ?? '127.0.0.1') . ";port=" . ($env['DB_PORT'] ?? '3306') . ";dbname=" . ($env['DB_DATABASE'] ?? '') . ";charset=utf8";
        $pdo = new PDO($dsn, $env['DB_USERNAME'] ?? '', $env['DB_PASSWORD'] ?? '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        // Query beritas
        echo "<h3>3. Data dari tabel 'beritas'</h3>";
        $stmt = $pdo->query("SELECT id, judul, gambar, is_published, created_at FROM beritas ORDER BY id DESC");
        $beritas = $stmt->fetchAll();
        
        if (count($beritas) > 0) {
            echo "Total records: <b>" . count($beritas) . "</b>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Judul</th><th>Nama File Gambar</th><th>File Fisik Ada?</th><th>Status</th></tr>";
            foreach ($beritas as $row) {
                $gambarPath = $row['gambar'];
                $physicalFile = __DIR__ . '/storage/' . $gambarPath;
                $fileExists = (!empty($gambarPath) && file_exists($physicalFile)) ? "<b style='color:green;'>YA</b>" : "<b style='color:red;'>TIDAK</b>";
                if (empty($gambarPath)) $fileExists = "<span class='text-muted'>Kosong</span>";
                
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['judul']) . "</td>";
                echo "<td><code>" . htmlspecialchars($gambarPath ?? '-') . "</code></td>";
                echo "<td>" . $fileExists . "</td>";
                echo "<td>" . ($row['is_published'] ? 'Publikasi' : 'Draft') . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Tabel 'beritas' kosong.</p>";
        }
        
    } catch (Exception $e) {
        echo "<div class='alert error'>Error Koneksi: " . $e->getMessage() . "</div>";
    }
    ?>
</body>
</html>
