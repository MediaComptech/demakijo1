<?php

/**
 * Global Helper Functions
 * 
 * File ini berisi fungsi-fungsi pembantu (helpers) yang sering digunakan
 * di seluruh aplikasi. Tujuannya adalah untuk mempermudah penulisan kode
 * oleh junior programmer.
 */

if (!function_exists('view')) {
    /**
     * Memanggil template view BladeOne.
     * 
     * @param string $view Nama file view (contoh: 'home.index')
     * @param array $data Data yang dikirim ke view
     * @return string Hasil render HTML
     */
    function view($view, $data = []) {
        return \App\Core\App::view($view, $data);
    }
}

if (!function_exists('json')) {
    /**
     * Mengembalikan response berupa JSON (untuk keperluan API atau AJAX).
     * 
     * @param mixed $data Data array atau object
     * @param int $status HTTP status code (default: 200)
     */
    function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

if (!function_exists('redirect')) {
    /**
     * Melakukan redirect ke URL tertentu.
     * 
     * @param string $path Path tujuan (contoh: '/login')
     */
    function redirect($path) {
        header("Location: " . url($path));
        exit;
    }
}

if (!function_exists('url')) {
    /**
     * Mendapatkan URL absolut aplikasi.
     * 
     * @param string $path Path relatif
     * @return string URL absolut
     */
    function url($path = '') {
        $baseUrl = rtrim($_ENV['APP_URL'] ?? 'http://localhost:8000', '/');
        $path = ltrim($path, '/');
        return $path ? "{$baseUrl}/{$path}" : $baseUrl;
    }
}

if (!function_exists('asset')) {
    /**
     * Mendapatkan URL untuk aset public (CSS, JS, Images).
     * 
     * @param string $path Path aset di folder public
     * @return string URL aset
     */
    function asset($path) {
        return url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Mendapatkan CSRF Token untuk proteksi form.
     * 
     * @return string CSRF token
     */
    function csrf_token() {
        return \App\Core\Security::getCsrfToken();
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Membuat input hidden untuk CSRF Token.
     * 
     * @return string Tag input hidden HTML
     */
    function csrf_field() {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}

if (!function_exists('old')) {
    /**
     * Mendapatkan input lama (old input) setelah validasi gagal.
     * 
     * @param string $key Nama field
     * @param string $default Nilai default jika kosong
     * @return string Nilai lama
     */
    function old($key, $default = '') {
        return \App\Core\Session::getFlash("old_{$key}") ?? $default;
    }
}

if (!function_exists('env')) {
    /**
     * Mengambil nilai dari environment variable (.env).
     * 
     * @param string $key Nama key
     * @param mixed $default Nilai default
     * @return mixed
     */
    function env($key, $default = null) {
        return $_ENV[$key] ?? $default;
    }
}
