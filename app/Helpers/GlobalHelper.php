<?php

/**
 * Global helper functions untuk menggantikan Laravel helpers.
 * File ini di-require otomatis via composer autoload.
 */

if (!function_exists('view')) {
    function view(string $template, array $data = [])
    {
        return \App\Core\View::render($template, $data);
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        $base = rtrim($_ENV['APP_URL'] ?? 'http://localhost:8000', '/');
        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url)
    {
        // support for route dot notation (admin.berita.index -> /admin/berita)
        if (strpos($url, '.') !== false && strpos($url, '/') === false) {
             $url = '/' . str_replace('.', '/', $url);
             $url = preg_replace('/\/index$/', '', $url);
        }

        return new class($url) {
            private $url;
            public function __construct($url) { $this->url = $url; }
            public function route($name) {
                 $this->url = '/' . str_replace('.', '/', $name);
                 $this->url = preg_replace('/\/index$/', '', $this->url);
                 return $this;
            }
            public function with($key, $value = null) {
                \App\Core\Session::setFlash($key, $value);
                return $this;
            }
            public function __destruct() {
                // Prevent duplicate headers during testing or multiple calls
                if (!headers_sent()) {
                    header('Location: ' . $this->url);
                    exit;
                }
            }
        };
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        $base = rtrim($_ENV['APP_URL'] ?? 'http://localhost:8000', '/');
        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        return '<input type="hidden" name="_token" value="' . \App\Core\Security::generateCsrfToken() . '">';
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        return \App\Core\Security::generateCsrfToken();
    }
}

if (!function_exists('old')) {
    function old(string $key, $default = '')
    {
        return \App\Core\Session::getFlash('old_' . $key) ?? $default;
    }
}

if (!function_exists('session')) {
    function session($key = null, $default = null)
    {
        if ($key === null) {
            return \App\Core\Session::class;
        }
        // Support array: session(['key' => 'value'])
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                \App\Core\Session::set($k, $v);
            }
            return;
        }
        return \App\Core\Session::get($key, $default);
    }
}

if (!function_exists('auth')) {
    function auth()
    {
        return new class {
            public function check() { return \App\Core\Auth::check(); }
            public function user()  { return \App\Core\Auth::user(); }
            public function id()    { return \App\Core\Session::get('user_id'); }
        };
    }
}

if (!function_exists('back')) {
    function back()
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        return new class($referer) {
            private $url;
            public function __construct($url) { $this->url = $url; }
            public function with($key, $value = null) {
                \App\Core\Session::setFlash($key, $value);
                return $this;
            }
            public function __destruct() {
                header('Location: ' . $this->url);
                exit;
            }
        };
    }
}

if (!function_exists('now')) {
    function now(): string
    {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('compact')) {
    // PHP already has compact() built-in, no override needed
}

if (!function_exists('abort')) {
    function abort(int $code = 404, string $message = '')
    {
        http_response_code($code);
        $messages = [
            404 => '404 - Halaman Tidak Ditemukan',
            403 => '403 - Akses Ditolak',
            500 => '500 - Kesalahan Server',
        ];
        die($messages[$code] ?? $message ?: 'Error ' . $code);
    }
}

if (!function_exists('route')) {
    function route(string $name, $params = []): string
    {
        // Simplified: return URL path as-is (no named routes in native MVC)
        // Developers should replace route() calls with url() manually
        return '/' . str_replace('.', '/', $name);
    }
}

if (!function_exists('request')) {
    function request($key = null, $default = null)
    {
        if ($key === null) return new \App\Core\Request();
        return (new \App\Core\Request())->input($key, $default);
    }
}

if (!function_exists('config')) {
    function config(string $key, $default = null)
    {
        // Minimal config helper
        $parts = explode('.', $key, 2);
        $file  = $parts[0];
        $subkey = $parts[1] ?? null;

        $configPath = __DIR__ . '/../../config/' . $file . '.php';
        if (!file_exists($configPath)) return $default;

        $config = require $configPath;
        if ($subkey === null) return $config;
        return $config[$subkey] ?? $default;
    }
}
