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
use App\Models\keranjang_pengadaan;
use App\Models\pengadaan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


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
            'cek1' => $cek1,
            'cek2' => $cek2,
        ]);
    }
    public function goPeserta()
    {
        $cek = DB::table('trainings')->count();
        return view('petugas.layout.peserta')->with([
            'title' => 'Data Peserta Training',
            'active' => 'Data Peserta Training',
            'pesertas' => peserta_training::all(),
            'cek' => $cek,
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
        $keranjangs = DB::table('keranjang_pengadaans')
                    ->join('barangs', 'keranjang_pengadaans.no_barang', '=', 'barangs.no_barang')
                    ->select('keranjang_pengadaans.*', 'barangs.nama_barang')
                    ->get();

        $total_harga = DB::table('keranjang_pengadaans')
        ->sum('harga');


        $detail_barang = DB::table('detail_barangs')
            ->join('pengadaans', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
            ->select('pengadaans.tanggal_pengadaan', 'detail_barangs.*')
            ->get();

        // dd($keranjang);


        return view('petugas.layout.transaksi.pengadaan')->with([
            'title' => 'Pengadaan',
            'active' => 'Pengadaan',
            'barangs' => $detail_barang,
            'keranjangs' => $keranjangs,
            'total_harga' => $total_harga
        ]);
    }
    public function goPengadaanTambah()
    {

        $noPengadaan = "PA-" . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis');
        $barangAll = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();
        $today = date('Y-m-d');

        return view('petugas.layout.transaksi.pengadaan-tambah')->with([
            'title' => 'Buat Pengadaan',
            'active' => 'Pengadaan',
            'detail_barangs' => detail_barang::all(),
            'barangs' => $barangAll,
            'noPengadaan' => $noPengadaan,
            'today' => $today

        ]);
    }
    public function goPenempatan()
    {
        $detail_barang = DB::table('detail_barangs')
            ->join('pengadaans', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
            ->select('pengadaans.tanggal_pengadaan', 'detail_barangs.*')
            ->get();

        // dd($keranjang);


        return view('petugas.layout.transaksi.penempatan')->with([
            'title' => 'Penempatan',
            'active' => 'Penempatan',
            'barangs' => $detail_barang,
        ]);
    }
    //end route view

    public function select(Request $request)
    {

        $id = $request->input('no_barang');



        $data_barang = DB::table('barangs')->select('*')->where('no_barang', '=', $id)->first();

        $kode_barcode = $noPengadaan = "$data_barang->kode_awal" . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis');

        // dd($kode_barcode);

        $barangAll = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();

        return view('petugas.layout.transaksi.pengadaan-tambah-data')->with([
            'title' => 'Buat Pengadaan',
            'active' => 'Pengadaan',
            'data_barang' => $data_barang,
            'barangs' => $barangAll,
            'kode_barcode' => $kode_barcode,
        ]);


    }
    public function addKeranjang(Request $request)
    {
        $validatedData = $request->validate([
            // 'no_pengadaan' => 'required',
            'no_barang' => 'required',
            'kode_barcode' => 'required',
            'no_asset' => 'required',
            'merk' => 'required|max:255',
            'jenis_pengadaan' => 'required',
            'spesifikasi' => 'required|max:255',
            'kondisi' => 'required',
            'status' => 'required',
            'harga' => 'required|numeric',
            'keterangan' => 'required|max:255',
        ]);

        $validatedData['no_asset'] = $request->input('kode_awal') .'-' . $request->input('no_asset').'-LC';

        keranjang_pengadaan::create($validatedData);

        $request->session()->flash('success', 'Barang masuk kedalam List Pengadaan!');

        return redirect('/pengadaan');
    }
    public function deleteKeranjang(Request $request)
    {

        $nama_barang = DB::table('keranjang_pengadaans')
            ->select('*')
            ->where('id', '=', $request->input('id_keranjang'))
            ->get();

        DB::table('keranjang_pengadaans')
                    ->where('id', $request->input('id_keranjang'))->delete();

        $pesanFlash = "Barang (Merk: *{$nama_barang[0]->merk} ) telah berhasil dihapus!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/pengadaan');
    }
    public function addPengadaan(Request $request)
    {


        $keranjangs = DB::table('keranjang_pengadaans')
            ->select('*')
            ->get();

        // foreach ($keranjangs as $keranjang) {
        //     $validatedData['no_pengadaan'] = $request->no_pengadaan;
        //     $validatedData['no_barang'] = $keranjang->no_barang;
        //     $validatedData['kode_barcode'] = $keranjang->kode_barcode;
        //     $validatedData['no_asset'] = $keranjang->no_asset;
        //     $validatedData['merk'] = $keranjang->merk;
        //     $validatedData['jenis_pengadaan'] = $keranjang->jenis_pengadaan;
        //     $validatedData['spesifikasi'] = $keranjang->spesifikasi;
        //     $validatedData['kondisi'] = $keranjang->kondisi;
        //     $validatedData['status'] = $keranjang->status;
        //     $validatedData['harga'] = $keranjang->harga;
        //     $validatedData['keterangan'] = $keranjang->keterangan;
        //     $validatedData['tanggal_pengadaan'] = now()->format('Y-m-d');

        //     detail_barang::create($validatedData);
        // }

        // pengadaan::create($validatedDataPengadaan);
        // DB::table('keranjang_pengadaans')->truncate();

        $datenow = now()->format('Y-m-d');

        // $no_last = DB::table('keranjang_pengadaans')->select('*')->orderByDesc('no_pengadaan')->first();
        $no_last = DB::table('pengadaans')
            ->select(DB::raw('RIGHT(no_pengadaan, 4) + 1 as noUrut'))
            ->orderBy('no_pengadaan', 'DESC')
            ->limit(1)
            ->get();



        // $no_count = DB::table('keranjang_pengadaans')->select('*')->count();
        // dd($no_last);

        if (!$no_last->isEmpty()) {
            $noUrut = $no_last[0]->noUrut;
            $floatValue = floatval($noUrut);
        }
        if ($no_last->isEmpty()) {
            $no_pengadaan_last = '0001';
        } else {
            if ($noUrut < 10) {
                $no_pengadaan_last = '000' . $noUrut;
            } elseif ($noUrut < 100) {
                $no_pengadaan_last = '00' . $noUrut;
            } elseif ($noUrut < 1000) {
                $no_pengadaan_last = '0' . $noUrut;
            } elseif ($noUrut < 10000) {
                $no_pengadaan_last = $noUrut;
            } else {
                $no_pengadaan_last = '0001';
            }
        }

        $no_pengadaan =
            'P' . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis') . $no_pengadaan_last;

        $headPengadaan = new pengadaan();
        $headPengadaan->no_pengadaan = $no_pengadaan;
        $headPengadaan->tanggal_pengadaan = $request->input('tanggal_pengadaan');
        $headPengadaan->save();

        DB::statement("INSERT INTO detail_barangs (no_pengadaan, no_barang, kode_barcode, no_asset, merk, jenis_pengadaan, spesifikasi, kondisi, status, harga, keterangan)
         SELECT '$no_pengadaan', no_barang, kode_barcode, no_asset, merk, jenis_pengadaan, spesifikasi, kondisi, status, harga, keterangan FROM keranjang_pengadaans");

        DB::table('keranjang_pengadaans')->truncate();

        $request->session()->flash('success', 'Data telah berhasil ditambahkan!');

        return redirect('/pengadaan');
    }
    public function deleteDetail(Request $request)
    {

        $nama_barang = DB::table('detail_barangs')
            ->select('merk')
            ->where('id', '=', $request->input('id_detail'))
            ->get();

        DB::table('detail_barangs')->where('id', $request->input('id_detail'))->delete();

        $pesanFlash = "Barang (Merk: *{$nama_barang[0]->merk} ) telah berhasil dihapus!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/pengadaan');
    }

    // Transaksi PENGADAAN
    // End End Transaksi PENGADAAN

}
