<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $guarded = [];

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }
}
