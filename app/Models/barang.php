<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_barang',
        'nama_barang',
        'kode_awal',
        'id_kategori',
        'qty',
    ];

    public static function generateKode()
    {
        $latestProduct = barang::orderBy('no_barang', 'desc')->first();
        if (!$latestProduct) {
            $number = 1;
        } else {
            $number = intval(substr($latestProduct->no_barang, 3)) + 1;
        }

        return 'BRG' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
