<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SUController extends Controller
{
    public function index()
    {
        return view(
            'super_user.layout.dashboard',
            [
                "title" => "Dashboard",
                "active" => "z"
            ]
        );
    }

    public function goPetugas()
    {
        return view('super_user.layout.petugas')->with([
            'title' => 'Data Petugas',
            'active' => 'z'

        ]);
    }

    public function goPegawai()
    {
        return view('super_user.layout.pegawai')->with([
            'title' => 'Data Pegawai',
            'active' => 'z'

        ]);
    }
    public function goBarang()
    {
        return view('super_user.layout.barang')->with([
            'title' => 'Data Barang',
            'active' => 'z'

        ]);
    }
    public function goRuangan()
    {
        return view('super_user.layout.ruangan')->with([
            'title' => 'Data Ruangan',
            'active' => 'z'

        ]);
    }
}
