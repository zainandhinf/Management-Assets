<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'nama_user',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'foto',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];


    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

}
