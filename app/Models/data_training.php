<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_training extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_training',
        'keterangan',
    ];
}
