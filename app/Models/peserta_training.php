<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peserta_training extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'id_training',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
