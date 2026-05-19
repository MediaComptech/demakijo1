<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Kelas Model
 * 
 * Base Model yang meng-extend Standalone Eloquent Model.
 * Semua model aplikasi (misal: Siswa, Guru) akan meng-extend kelas ini.
 */
class Model extends EloquentModel
{
    // Menggunakan Eloquent bawaan, sehingga fungsi hasMany, belongsTo, dll otomatis tersedia.
    // Jika butuh method custom global untuk semua model, tambahkan di sini.
}
