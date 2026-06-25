<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas'; // explicit — ends in 's' so Eloquent might add 'es'
    protected $guarded = [];
}
