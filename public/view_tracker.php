<?php
// view_tracker.php - View form submission logs and database errors
require_once __DIR__ . '/../vendor/autoload.php';

// Boot session for authentication check
\App\Core\Session::start();

// Load .env configuration
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
try {
    $dotenv->load();
} catch (\Exception $e) {
    // ignore
}

// Simple authentication block
if (!\App\Core\Auth::check()) {
    header('HTTP/1.0 403 Forbidden');
    echo "<div style='font-family:sans-serif; padding:50px; text-align:center;'>";
    echo "<h2>Akses Ditolak (403)</h2>";
    echo "<p>Silakan <a href='/login'>Login sebagai Admin/Operator</a> terlebih dahulu untuk melihat log pelacakan.</p>";
    echo "</div>";
    exit;
}

$logFile = __DIR__ . '/../storage/action_tracker.log';
$logs = [];

if (file_exists($logFile)) {
    $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $data = json_decode($line, true);
        if ($data) {
            $logs[] = $data;
        }
    }
    // Show newest first
    $logs = array_reverse($logs);
}

// Handle clear log action
if (isset($_POST['action']) && $_POST['action'] === 'clear') {
    @file_put_contents($logFile, '');
    header('Location: view_tracker.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Action & Query Error Tracker</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; padding: 25px; background: #f1f5f9; color: #1e293b; }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px 25px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 25px; }
        h1 { margin: 0; font-size: 20px; color: #0f172a; }
        .btn { padding: 8px 16px; border-radius: 6px; font-weight: 600; font-size: 14px; text-decoration: none; border: none; cursor: pointer; }
        .btn-danger { background: #ef4444; color: white; }
        .btn-danger:hover { background: #dc2626; }
        .btn-secondary { background: #e2e8f0; color: #475569; }
        .btn-secondary:hover { background: #cbd5e1; }
        .log-card { background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 15px; border-left: 5px solid #cbd5e1; overflow: hidden; }
        .log-header { padding: 12px 20px; background: #f8fafc; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .log-body { padding: 15px 20px; font-size: 14px; }
        .timestamp { color: #64748b; font-size: 13px; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        
        /* Badges styling */
        .type-REQUEST_POST { border-left-color: #3b82f6; }
        .badge-REQUEST_POST { background: #dbeafe; color: #1e40af; }
        
        .type-SUCCESS { border-left-color: #22c55e; }
        .badge-SUCCESS { background: #dcfce7; color: #15803d; }
        
        .type-DB_ERROR { border-left-color: #ef4444; }
        .badge-DB_ERROR { background: #fee2e2; color: #b91c1c; }
        
        .type-APP_ERROR { border-left-color: #f97316; }
        .badge-APP_ERROR { background: #ffedd5; color: #c2410c; }
        
        .type-DISPATCH_CONTROLLER { border-left-color: #a855f7; }
        .badge-DISPATCH_CONTROLLER { background: #f3e8ff; color: #6b21a8; }

        .type-GET_NORMAL { border-left-color: #64748b; }
        .badge-GET_NORMAL { background: #e2e8f0; color: #475569; }

        .type-GET_CTRL_F5 { border-left-color: #f59e0b; }
        .badge-GET_CTRL_F5 { background: #fef3c7; color: #b45309; }
        
        pre { background: #0f172a; color: #38bdf8; padding: 12px; border-radius: 6px; font-family: monospace; font-size: 13px; overflow-x: auto; margin-top: 8px; margin-bottom: 0; }
        .text-muted { color: #64748b; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 10px; }
        .info-item b { color: #475569; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Aktivitas & Log Error Pelacakan (sdndemakijo1)</h1>
                <p style="margin: 5px 0 0 0; font-size: 13px; color: #64748b;">Hanya menampilkan log aktivitas POST, data input, dan database error dari dashboard admin.</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh log tracker?');">
                    <input type="hidden" name="action" value="clear">
                    <button type="submit" class="btn btn-danger">Hapus Log</button>
                </form>
                <a href="/admin/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
            </div>
        </div>

        <?php if (empty($logs)): ?>
            <div style="background: white; padding: 40px; text-align: center; border-radius: 12px; color: #64748b; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <p style="margin: 0; font-size: 16px; font-weight: 500;">Belum ada log pelacakan yang tercatat.</p>
                <p style="margin: 10px 0 0 0; font-size: 13px;">Lakukan submit form berita atau pengumuman untuk merekam aktivitas.</p>
            </div>
        <?php else: ?>
            <?php foreach ($logs as $log): ?>
                <?php 
                $type = $log['type'] ?? 'INFO'; 
                $cardClass = 'type-' . $type;
                $badgeClass = 'badge-' . $type;
                ?>
                <div class="log-card <?php echo $cardClass; ?>">
                    <div class="log-header">
                        <div>
                            <span class="badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($type); ?></span>
                            <span class="timestamp" style="margin-left: 10px;"><b style="color:#1e293b;"><?php echo htmlspecialchars($log['method'] ?? 'GET'); ?></b> <code><?php echo htmlspecialchars($log['uri'] ?? '/'); ?></code></span>
                        </div>
                        <div class="timestamp"><?php echo htmlspecialchars($log['timestamp'] ?? ''); ?></div>
                    </div>
                    <div class="log-body">
                        <div class="info-grid">
                            <div class="info-item"><b>IP Address:</b> <?php echo htmlspecialchars($log['ip'] ?? '-'); ?></div>
                            <div class="info-item"><b>User ID:</b> <?php echo htmlspecialchars($log['user_id'] ?? 'Guest'); ?></div>
                        </div>
                        
                        <?php if ($type === 'REQUEST_POST' && isset($log['data']['post'])): ?>
                            <div style="margin-top: 10px;">
                                <b>Data Form POST yang Dikirim:</b>
                                <pre><?php echo htmlspecialchars(print_r($log['data']['post'], true)); ?></pre>
                            </div>
                            <?php if (!empty($log['data']['files'])): ?>
                                <div style="margin-top: 10px;">
                                    <b>File Upload yang Terdeteksi:</b>
                                    <pre><?php echo htmlspecialchars(print_r($log['data']['files'], true)); ?></pre>
                                </div>
                            <?php endif; ?>
                        
                        <?php elseif ($type === 'DISPATCH_CONTROLLER'): ?>
                            <div style="margin-top: 5px;">
                                <b>Route Terhubung ke Controller:</b>
                                <div>Controller Class: <code><?php echo htmlspecialchars($log['data']['controller'] ?? ''); ?></code></div>
                                <div>Method/Action: <code><?php echo htmlspecialchars($log['data']['method'] ?? ''); ?></code></div>
                            </div>

                        <?php elseif ($type === 'GET_NORMAL' || $type === 'GET_CTRL_F5'): ?>
                            <div style="margin-top: 5px;">
                                <b>Akses Halaman GET (<?php echo ($type === 'GET_CTRL_F5') ? '⚠️ Bypass Cache / Ctrl + F5' : 'Normal'; ?>):</b>
                                <div style="font-size:12px; margin-top:5px; line-height: 1.6;">
                                    <div>Cache-Control Header: <code><?php echo htmlspecialchars($log['data']['cache_control'] ?? 'none'); ?></code></div>
                                    <div>Pragma Header: <code><?php echo htmlspecialchars($log['data']['pragma'] ?? 'none'); ?></code></div>
                                    <div class="text-muted" style="margin-top:3px;">User Agent: <?php echo htmlspecialchars($log['data']['user_agent'] ?? '-'); ?></div>
                                </div>
                            </div>
                        
                        <?php elseif ($type === 'DB_ERROR'): ?>
                            <div style="margin-top: 10px; color: #b91c1c;">
                                <b>❌ DATABASE EXCEPTION OCCURRED:</b>
                                <div style="font-weight: bold; margin-bottom: 5px;"><?php echo htmlspecialchars($log['data']['message'] ?? ''); ?></div>
                                <b>SQL Query:</b>
                                <pre><?php echo htmlspecialchars($log['data']['sql'] ?? ''); ?></pre>
                                <?php if (!empty($log['data']['bindings'])): ?>
                                    <b style="display:block; margin-top: 5px;">Parameters Bindings:</b>
                                    <pre><?php echo htmlspecialchars(print_r($log['data']['bindings'], true)); ?></pre>
                                <?php endif; ?>
                            </div>
                            
                        <?php elseif ($type === 'APP_ERROR'): ?>
                            <div style="margin-top: 10px; color: #c2410c;">
                                <b>⚠️ APPLICATION RUNTIME ERROR:</b>
                                <div style="font-weight: bold; margin-bottom: 5px;">[<?php echo htmlspecialchars($log['data']['class'] ?? ''); ?>] <?php echo htmlspecialchars($log['data']['message'] ?? ''); ?></div>
                                <div>Di file: <code><?php echo htmlspecialchars($log['data']['file'] ?? ''); ?></code> pada baris <code><?php echo htmlspecialchars($log['data']['line'] ?? ''); ?></code></div>
                                <b style="display:block; margin-top: 5px;">Trace Summary:</b>
                                <pre><?php echo htmlspecialchars($log['data']['trace'] ?? ''); ?></pre>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
