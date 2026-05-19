<?php

namespace App\Core;

/**
 * Kelas Controller
 * 
 * Base Controller yang akan di-extend oleh semua controller aplikasi.
 * Menyediakan fungsi-fungsi dasar yang umum digunakan.
 */
class Controller
{
    /**
     * Konstruktor default.
     * Bisa digunakan untuk inisialisasi middleware jika diperlukan nantinya.
     */
    public function __construct()
    {
        // 
    }

    /**
     * Render view
     */
    protected function view($view, $data = [])
    {
        return App::view($view, $data);
    }

    /**
     * Response JSON
     */
    protected function json($data, $status = 200)
    {
        return json($data, $status);
    }

    /**
     * Mendapatkan input POST/GET dengan sanitasi dasar
     */
    protected function input($key = null, $default = null)
    {
        if ($key === null) {
            $data = array_merge($_GET, $_POST);
            foreach ($data as $k => $v) {
                if (is_string($v)) {
                    $data[$k] = htmlspecialchars(trim($v));
                }
            }
            return $data;
        }

        $val = $_POST[$key] ?? $_GET[$key] ?? $default;
        if (is_string($val)) {
            return htmlspecialchars(trim($val));
        }
        return $val;
    }
}
