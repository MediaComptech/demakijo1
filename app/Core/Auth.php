<?php

namespace App\Core;

use App\Models\User; // Asumsi menggunakan model User dari Eloquent

/**
 * Kelas Auth
 * 
 * Menangani otentikasi (login/logout) dan pengecekan role.
 */
class Auth
{
    /**
     * Cek apakah user sudah login
     */
    public static function check()
    {
        return Session::has('user_id');
    }

    /**
     * Mendapatkan object user yang sedang login
     */
    public static function user()
    {
        if (self::check()) {
            return User::find(Session::get('user_id'));
        }
        return null;
    }

    /**
     * Proses Login
     */
    public static function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            Session::regenerate(); // Mencegah session fixation
            Session::set('user_id', $user->id);
            return true;
        }

        return false;
    }

    /**
     * Proses Logout
     */
    public static function logout()
    {
        Session::remove('user_id');
        Session::destroy();
    }
}
