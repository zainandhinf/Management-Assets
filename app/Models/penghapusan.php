<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penghapusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_penghapusan',
        'tanggal_penghapusan',
        'jenis_penghapusan',
        'keterangan',
    ];
}