<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ruangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_ruangan',
        'ruangan',
        'lokasi',
        'kapasitas',
        'tipe_ruangan',
    ];

    public function checkAvailability($tanggalMulai, $tanggalSelesai)
    {
        // Lakukan logika untuk memeriksa ketersediaan ruangan
        // Misalnya, periksa apakah ada reservasi pada rentang tanggal tersebut

        $reservations = $this->reservations()->where(function ($query) use ($tanggalMulai, $tanggalSelesai) {
            $query->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalSelesai])
                ->orWhereBetween('tanggal_selesai', [$tanggalMulai, $tanggalSelesai])
                ->orWhere(function ($query) use ($tanggalMulai, $tanggalSelesai) {
                    $query->where('tanggal_mulai', '<=', $tanggalMulai)
                        ->where('tanggal_selesai', '>=', $tanggalSelesai);
                });
        })->count();

        return $reservations == 0;
    }

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

}
