<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nik' =>'50977',
            'nama_user' =>'User',
            'jenis_kelamin' =>'Laki-Laki',
            'alamat' =>'',
            'no_telepon' =>'',
            'foto' =>'',
            'username' =>'user',
            'password' => Hash::make('111'),
            'role' =>'super_user',
        ]);
    }
}
