<?php

return [
    'name' => $_ENV['APP_NAME'] ?? 'Demakijo 1',
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => (bool) ($_ENV['APP_DEBUG'] ?? false),
    'url' => $_ENV['APP_URL'] ?? 'http://localhost',
    'timezone' => 'Asia/Jakarta',
    'locale' => 'id',
];
