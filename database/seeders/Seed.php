<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class Seed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nik' =>'50977',
            'nama_user' =>'Super User',
            'jenis_kelamin' =>'L',
            'alamat' =>'',
            'no_telepon' =>'',
            'foto' =>'',
            'username' =>'super user',
            'password' => Hash::make('111'),
            'role' =>'super_user',
        ]);
        DB::table('users')->insert([
            'nik' =>'50979',
            'nama_user' =>'Koordinator',
            'jenis_kelamin' =>'L',
            'alamat' =>'',
            'no_telepon' =>'',
            'foto' =>'',
            'username' =>'koor',
            'password' => Hash::make('111'),
            'role' =>'petugas',
        ]);
        DB::table('kategori_barangs')->insert([
            'nama_kategori' =>'Elektronik',
        ]);
        DB::table('barangs')->insert([
            'no_barang' =>'BRG0001',
            'kode_awal' =>'LP',
            'nama_barang' =>'Laptop',
            'id_kategori' =>'1',
            'qty' =>'0',
        ]);
        DB::table('tipe_ruangans')->insert([
            'nama_tipe' =>'Ruang Training',
            'keterangan' =>'Untuk melakukan Hal-hal dan kegiatan berkenaan dengan Training untuk para pegawai PT. DI',
        ]);
        DB::table('ruangans')->insert([
            'no_ruangan' =>'Ruang-211',
            'ruangan' =>'Ruang Training 211',
            'lokasi' =>'Lt. 3 Gedung Diklat, Pusat Pembelajaran',
            'kapasitas' =>'2',
            'tipe_ruangan' =>'1',
        ]);
        DB::table('ruangans')->insert([
            'no_ruangan' =>'R-212',
            'ruangan' =>'Ruang Training 212',
            'lokasi' =>'Lt. 3 Gedung Diklat, Pusat Pembelajaran',
            'kapasitas' =>'36',
            'tipe_ruangan' =>'1',
        ]);
        DB::table('pegawais')->insert([
            'nik' =>'1111',
            'nama_user' =>'Toni Kroos',
            'jenis_kelamin' =>'L',
            'alamat' =>'Bandung, JL. Braga No. 10',
            'no_telepon' =>'0812345678910',
            'foto' =>'',
            'organisasi' =>'IT5000',
        ]);
        DB::table('pegawais')->insert([
            'nik' =>'2222',
            'nama_user' =>'Erling Haaland',
            'jenis_kelamin' =>'L',
            'alamat' =>'Bandung, JL. Asia Afrika No. 11',
            'no_telepon' =>'088811112234',
            'foto' =>'',
            'organisasi' =>'UI2500',

        ]);
        DB::table('pegawais')->insert([
            'nik' =>'3333',
            'nama_user' =>'Asep Jamaludin',
            'jenis_kelamin' =>'P',
            'alamat' =>'Bandung, JL. Asia Afrika No. 12',
            'no_telepon' =>'081123456789',
            'foto' =>'',
            'organisasi' =>'SC7000',

        ]);
        DB::table('pegawais')->insert([
            'nik' =>'4444',
            'nama_user' =>'Febri Hariadi',
            'jenis_kelamin' =>'P',
            'alamat' =>'Bandung, JL. Asia Afrika No. 14',
            'no_telepon' =>'081243546576',
            'foto' =>'',
            'organisasi' =>'HD3000',

        ]);

    }
}
