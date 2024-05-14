<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\pegawai;
use App\Models\kategori_barang;
use App\Models\ruangan;
use App\Models\tipe_ruangan;
use App\Models\barang;
use App\Models\image_ruangan;
use App\Models\training;
use App\Models\peserta_training;
use App\Models\detail_barang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PController extends Controller
{
    // route view
    public function index()
    {
        return view(
            'petugas.layout.dashboard',
            [
                "title" => "Dashboard",
                "active" => "Dashboard"
            ]
        );
    }

    public function goPetugas()
    {
        return view('petugas.layout.petugas')->with([
            'title' => 'Data Petugas',
            'active' => 'Data Petugas',
            'petugass' => User::all(),

        ]);
    }

    public function goPegawai()
    {
        return view('petugas.layout.pegawai')->with([
            'title' => 'Data Pegawai',
            'active' => 'Data Pegawai',
            'pegawais' => pegawai::all(),

        ]);
    }
    public function goBarang()
    {
        // $barangAll = barang::all();


        $cekKategori = DB::table('kategori_barangs')->count();

        $kategoris = kategori_barang::all();


        $kategori_barang = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();

        // dd($kategori_barang);

        return view('petugas.layout.barang')->with([
            'title' => 'Data Barang',
            'active' => 'Data Barang',
            'cek' => $cekKategori,
            'barangs' => $kategori_barang,
            'kategoris' => $kategoris,
            // 'kategori_barang' => $kategori_barang,

        ]);
    }
    public function goKBarang()
    {
        return view('petugas.layout.kategoribrg')->with([
            'title' => 'Data Kategori Barang',
            'active' => 'Data Kategori Barang',
            'ktgr_brngs' => kategori_barang::all(),
        ]);
    }
    public function goRuangan()
    {
        $cekTipe = DB::table('tipe_ruangans')->count();

        return view('petugas.layout.ruangan')->with([
            'title' => 'Data Ruangan',
            'active' => 'Data Ruangan',
            'cek' => $cekTipe,
            'ruangans' => ruangan::all(),

        ]);
    }
    public function goTRuangan()
    {
        return view('petugas.layout.tiperuangan')->with([
            'title' => 'Data Tipe Ruangan',
            'active' => 'Data Tipe Ruangan',
            'tipe_ruangans' => tipe_ruangan::all(),

        ]);
    }
    public function goTraining()
    {
        $cek1 = DB::table('users')->where('role', '=', 'petugas')->count();
        $cek2 = DB::table('ruangans')->count();
        return view('petugas.layout.training')->with([
            'title' => 'Data Training',
            'active' => 'Data Training',
            'trainings' => training::all(),
            'cek1'=> $cek1,
            'cek2'=> $cek2,
        ]);
    }
    public function goPeserta()
    {
        $cek = DB::table('trainings')->count();
        return view('petugas.layout.peserta')->with([
            'title' => 'Data Peserta Training',
            'active' => 'Data Peserta Training',
            'pesertas' => peserta_training::all(),
            'cek'=> $cek,
        ]);
    }
    public function goProfile()
    {
        return view('petugas.layout.profile')->with([
            'title' => 'Profile',
            'active' => 'Profile',

        ]);
    }
    public function goPengadaan()
    {
        return view('petugas.layout.transaksi.pengadaan')->with([
            'title' => 'Pengadaan',
            'active' => 'Pengadaan',
            'barangs' => detail_barang::all(),

        ]);
    }
    public function goPengadaanTambah()
    {
        return view('petugas.layout.transaksi.pengadaan-tambah')->with([
            'title' => 'Buat Pengadaan',
            'active' => 'Pengadaan',
            'barangs' => detail_barang::all(),

        ]);
    }
    //end route view

}
