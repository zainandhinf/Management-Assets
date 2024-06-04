<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keranjang_peminjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_peminjaman',
        'no_barang',
        'kode_barcode',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

}
