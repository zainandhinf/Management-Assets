<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_barang',
        'kode_aktiva',
        'nama_barang',
        'id_kategori',
        'qty',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
