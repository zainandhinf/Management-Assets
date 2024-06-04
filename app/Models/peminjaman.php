<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peminjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_peminjaman',
        'tanggal_peminjaman',
        'tanggal_kembali',
        'id_pegawai',
        'status_peminjaman',
        'keterangan',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
