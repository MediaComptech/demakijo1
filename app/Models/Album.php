<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function galeri()
    {
        return $this->hasMany(Galeri::class);
    }

    //
}
