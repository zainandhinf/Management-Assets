<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_penempatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_penempatan',
        'no_barang',
        'kode_barcode',
    ];
}
