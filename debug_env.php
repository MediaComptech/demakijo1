<?php
$root = realpath(__DIR__);
echo "Root: " . $root . PHP_EOL;
echo ".env exists: " . (file_exists($root . DIRECTORY_SEPARATOR . '.env') ? 'YES' : 'NO') . PHP_EOL;

// Simulate what App.php does - App.php is at app/Core/App.php so __DIR__ is app/Core
$appCoreDir = $root . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Core';
$dotenvPath = $appCoreDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
echo "Dotenv path: " . realpath($dotenvPath) . PHP_EOL;
echo ".env from dotenv path: " . (file_exists(realpath($dotenvPath) . DIRECTORY_SEPARATOR . '.env') ? 'YES' : 'NO') . PHP_EOL;

// Test loading dotenv
require $root . '/vendor/autoload.php';
try {
    $dotenv = Dotenv\Dotenv::createImmutable($root);
    $dotenv->load();
    echo "Dotenv loaded OK!" . PHP_EOL;
    echo "APP_NAME: " . ($_ENV['APP_NAME'] ?? 'not set') . PHP_EOL;
    echo "DB_DATABASE: " . ($_ENV['DB_DATABASE'] ?? 'not set') . PHP_EOL;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
