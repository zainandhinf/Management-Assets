<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keranjang_pengadaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_pengadaan',
        'no_barang',
        'kode_barcode',
        'no_asset',
        'merk',
        'jenis_pengadaan',
        'spesifikasi',
        'kondisi',
        'status',
        'harga',
        'foto_barang',
        'keterangan',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
