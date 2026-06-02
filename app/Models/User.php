<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // CATATAN: Jangan gunakan 'hashed' cast di sini!
        // Auth::attempt() menggunakan password_verify() secara langsung.
        // Cast 'hashed' akan menyebabkan double-hashing dan login selalu gagal.
    ];

    // Dummy method untuk HasRoles fallback jika digunakan di views
    public function hasRole($role)
    {
        // Untuk tahap awal konversi MVC, anggap user admin memiliki akses.
        // Nanti bisa dikembangkan dengan tabel role sungguhan
        return true; 
    }
}
