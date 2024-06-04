<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_maintenance',
        'no_barang',
        'kode_barcode',
        'tanggal_maintenance',
        'tanggal_selesai',
        'biaya',
        'status',
        'keterangan',
        'user_id'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
