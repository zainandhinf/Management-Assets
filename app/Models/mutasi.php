<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mutasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_mutasi',
        'tanggal_mutasi',
        'no_ruangan',
        'keterangan',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
