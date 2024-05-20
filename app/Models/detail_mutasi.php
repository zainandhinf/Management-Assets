<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_mutasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_mutasi',
        'no_barang',
        'kode_barcode',
    ];
}
