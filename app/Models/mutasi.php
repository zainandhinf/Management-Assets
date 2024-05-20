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
        'lokasi_terbaru',
        'keterangan',
    ];
}
