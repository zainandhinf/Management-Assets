<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image_ruangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'no_ruangan',
    ];
}
