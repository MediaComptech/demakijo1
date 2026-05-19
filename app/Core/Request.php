<?php

namespace App\Core;

class Request
{
    private $data;
    private $files;

    public function __construct()
    {
        $this->data = array_merge($_GET, $_POST);
        $this->files = $_FILES;
    }

    public function input($key = null, $default = null)
    {
        if ($key === null) return $this->data;
        return $this->data[$key] ?? $default;
    }

    public function all()
    {
        return $this->data;
    }

    public function get($key, $default = null)
    {
        return $this->input($key, $default);
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    public function hasFile($key)
    {
        return isset($this->files[$key]) && $this->files[$key]['error'] !== UPLOAD_ERR_NO_FILE;
    }

    public function file($key)
    {
        if ($this->hasFile($key)) {
            return (object) $this->files[$key];
        }
        return null;
    }

    public function has($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Cek apakah URL saat ini cocok dengan pattern yang diberikan.
     * Mendukung wildcard (*). Contoh: request()->is('admin/*')
     */
    public function is(string $pattern): bool
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $uri = '/' . trim($uri, '/');

        // Exact match
        if ($pattern === $uri) return true;

        // Wildcard match
        $regex = '#^' . str_replace('\*', '.*', preg_quote($pattern, '#')) . '$#';
        return (bool) preg_match($regex, $uri);
    }
}
