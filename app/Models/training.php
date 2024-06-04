<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class training extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'no_ruangan',
        'total_peserta',
        'instruktur',
        'id_petugas',
        // 'keterangan'

    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
