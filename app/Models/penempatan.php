<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penempatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_penempatan',
        'tanggal_penempatan',
        'no_ruangan',
        'user_id',
        'keterangan',
    ];
}
