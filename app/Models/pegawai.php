<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama_user',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'foto'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
