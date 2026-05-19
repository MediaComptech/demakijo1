<?php

namespace App\Core;

/**
 * Kelas Security
 * 
 * Menangani fungsi keamanan dasar seperti CSRF dan XSS Filtering.
 */
class Security
{
    /**
     * Generate CSRF Token dan simpan di session
     */
    public static function getCsrfToken()
    {
        if (!Session::has('_token')) {
            Session::set('_token', bin2hex(random_bytes(32)));
        }
        return Session::get('_token');
    }

    /**
     * Memverifikasi CSRF Token dari input POST
     */
    public static function verifyCsrfToken()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            if (!$token || $token !== Session::get('_token')) {
                http_response_code(419);
                die("Page Expired. Invalid CSRF Token.");
            }
        }
    }

    /**
     * XSS Filter sederhana
     */
    public static function escape($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}
