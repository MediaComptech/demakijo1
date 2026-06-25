<?php
/**
 * Debug Diagnostic Script - SDN Demakijo 1
 * Akses: https://sdndemakijo1.sch.id/debug.php
 * HAPUS file ini setelah deploy selesai!
 */

// Tampilkan semua error untuk diagnosa
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Tambah token keamanan sederhana
$token = $_GET['t'] ?? '';
if ($token !== 'demakijo2026debug') {
    http_response_code(403);
    die('Access denied. Tambahkan ?t=demakijo2026debug ke URL.');
}

echo '<!DOCTYPE html><html><head><meta charset="UTF-8">
<title>Debug - SDN Demakijo 1</title>
<style>
body{font-family:monospace;background:#1a1a2e;color:#eee;padding:20px}
h1{color:#e94560} h2{color:#0f3460;background:#e94560;padding:8px}
.ok{color:#00ff88} .fail{color:#ff4757} .warn{color:#ffa502}
pre{background:#16213e;padding:10px;border-radius:5px;overflow-x:auto}
table{border-collapse:collapse;width:100%} td,th{border:1px solid #333;padding:6px 10px}
</style></head><body>';

echo '<h1>🔍 Debug Diagnostics - SDN Demakijo 1</h1>';
echo '<p>Waktu server: ' . date('Y-m-d H:i:s T') . '</p>';

// ---- PHP Info ----
echo '<h2>1. PHP Environment</h2>';
echo '<table>';
echo '<tr><td>PHP Version</td><td class="' . (version_compare(PHP_VERSION, '8.2', '>=') ? 'ok' : 'fail') . '">' . PHP_VERSION . '</td></tr>';
echo '<tr><td>SAPI</td><td>' . php_sapi_name() . '</td></tr>';
echo '<tr><td>Memory Limit</td><td>' . ini_get('memory_limit') . '</td></tr>';
echo '<tr><td>max_execution_time</td><td>' . ini_get('max_execution_time') . 's</td></tr>';
echo '<tr><td>upload_max_filesize</td><td>' . ini_get('upload_max_filesize') . '</td></tr>';
echo '<tr><td>mod_rewrite</td><td class="' . (function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules()) ? 'ok' : 'warn') . '">' . (function_exists('apache_get_modules') ? (in_array('mod_rewrite', apache_get_modules()) ? '✅ aktif' : '❌ tidak aktif') : 'tidak dapat cek (mungkin ok via FastCGI)') . '</td></tr>';
echo '<tr><td>Extensions</td><td class="ok">' . implode(', ', ['pdo_mysql' => extension_loaded('pdo_mysql') ? '✅ pdo_mysql' : '❌ pdo_mysql', 'mbstring' => extension_loaded('mbstring') ? '✅ mbstring' : '❌ mbstring', 'openssl' => extension_loaded('openssl') ? '✅ openssl' : '❌ openssl']) . '</td></tr>';
echo '</table>';

// ---- Path & Files ----
echo '<h2>2. File & Directory Check</h2>';
$baseDir = __DIR__ . '/..';
$checks = [
    '.env'                => $baseDir . '/.env',
    'vendor/autoload.php' => $baseDir . '/vendor/autoload.php',
    'storage/cache/'      => $baseDir . '/storage/cache',
    'app/Core/App.php'    => $baseDir . '/app/Core/App.php',
    'routes/web.php'      => $baseDir . '/routes/web.php',
    'public/.htaccess'    => __DIR__ . '/.htaccess',
    'root .htaccess'      => $baseDir . '/.htaccess',
];

echo '<table><tr><th>File/Dir</th><th>Status</th><th>Writable</th></tr>';
foreach ($checks as $label => $path) {
    $exists = file_exists($path);
    $writable = is_writable($path);
    echo '<tr>';
    echo '<td>' . $label . '</td>';
    echo '<td class="' . ($exists ? 'ok' : 'fail') . '">' . ($exists ? '✅ Ada' : '❌ TIDAK ADA') . '</td>';
    echo '<td class="' . ($writable ? 'ok' : 'warn') . '">' . ($writable ? '✅' : '⚠️ Tidak writable') . '</td>';
    echo '</tr>';
}
echo '</table>';

// ---- ENV Loading ----
echo '<h2>3. .env File Content</h2>';
$envPath = $baseDir . '/.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    // Mask password
    $envSafe = preg_replace('/DB_PASSWORD=.+/m', 'DB_PASSWORD=***MASKED***', $envContent);
    $envSafe = preg_replace('/APP_KEY=.+/m', 'APP_KEY=***MASKED***', $envSafe);
    echo '<pre>' . htmlspecialchars($envSafe) . '</pre>';
} else {
    echo '<p class="fail">❌ File .env tidak ditemukan!</p>';
}

// ---- Vendor Check ----
echo '<h2>4. Vendor / Autoloader</h2>';
if (file_exists($baseDir . '/vendor/autoload.php')) {
    try {
        require_once $baseDir . '/vendor/autoload.php';
        echo '<p class="ok">✅ vendor/autoload.php berhasil di-load</p>';
        
        // Check key classes
        $classes = [
            'Illuminate\Database\Capsule\Manager' => 'illuminate/database',
            'eftec\bladeone\BladeOne'              => 'eftec/bladeone',
            'Dotenv\Dotenv'                        => 'vlucas/phpdotenv',
        ];
        echo '<table><tr><th>Class</th><th>Package</th><th>Status</th></tr>';
        foreach ($classes as $class => $pkg) {
            $exists = class_exists($class);
            echo '<tr><td>' . $class . '</td><td>' . $pkg . '</td><td class="' . ($exists ? 'ok' : 'fail') . '">' . ($exists ? '✅ OK' : '❌ MISSING') . '</td></tr>';
        }
        echo '</table>';
    } catch (Throwable $e) {
        echo '<p class="fail">❌ Error load autoloader: ' . $e->getMessage() . '</p>';
    }
} else {
    echo '<p class="fail">❌ vendor/autoload.php tidak ditemukan! Perlu jalankan composer install.</p>';
}

// ---- Database Connection Test ----
echo '<h2>5. Database Connection Test</h2>';
if (file_exists($envPath)) {
    // Parse .env manually
    $envVars = [];
    foreach (explode("\n", file_get_contents($envPath)) as $line) {
        $line = trim($line);
        if (empty($line) || str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            [$key, $val] = explode('=', $line, 2);
            $envVars[trim($key)] = trim($val, '"\'');
        }
    }
    
    $host = $envVars['DB_HOST'] ?? '127.0.0.1';
    $port = $envVars['DB_PORT'] ?? '3306';
    $db   = $envVars['DB_DATABASE'] ?? '';
    $user = $envVars['DB_USERNAME'] ?? '';
    $pass = $envVars['DB_PASSWORD'] ?? '';
    
    echo '<table>';
    echo '<tr><td>Host</td><td>' . $host . ':' . $port . '</td></tr>';
    echo '<tr><td>Database</td><td>' . $db . '</td></tr>';
    echo '<tr><td>Username</td><td>' . $user . '</td></tr>';
    echo '<tr><td>Password</td><td>***MASKED***</td></tr>';
    echo '</table>';
    
    try {
        $pdo = new PDO("mysql:host={$host};port={$port};dbname={$db}", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5,
        ]);
        echo '<p class="ok">✅ Koneksi Database BERHASIL!</p>';
        
        // List tables
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo '<p class="ok">📋 Jumlah tabel: ' . count($tables) . '</p>';
        if (count($tables) > 0) {
            echo '<pre>' . implode(', ', $tables) . '</pre>';
        } else {
            echo '<p class="warn">⚠️ Database kosong (0 tabel). Perlu import schema SQL!</p>';
        }
    } catch (PDOException $e) {
        echo '<p class="fail">❌ KONEKSI GAGAL: ' . $e->getMessage() . '</p>';
        if (str_contains($e->getMessage(), 'Unknown database')) {
            echo '<p class="warn">⚠️ Database belum dibuat di cPanel MySQL Databases!</p>';
        }
        if (str_contains($e->getMessage(), 'Access denied')) {
            echo '<p class="warn">⚠️ Username/password salah atau user belum diberi privilege!</p>';
        }
    }
}

// ---- Full App Boot Test ----
echo '<h2>6. Application Boot Test</h2>';
try {
    if (!class_exists('App\Core\App')) {
        require_once $baseDir . '/vendor/autoload.php';
    }
    \App\Core\App::boot();
    echo '<p class="ok">✅ App::boot() berhasil!</p>';
    
    // Test query
    $setting = \App\Models\SettingWebsite::first();
    echo '<p class="ok">✅ Query SettingWebsite berhasil. Data: ' . ($setting ? json_encode($setting->toArray()) : 'null (tabel kosong)') . '</p>';
} catch (Throwable $e) {
    echo '<p class="fail">❌ App Boot Error: <strong>' . $e->getMessage() . '</strong></p>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}

echo '<hr><p class="warn">⚠️ HAPUS file debug.php setelah selesai diagnosa!</p>';
echo '</body></html>';
