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
use App\Models\penempatan;
use App\Models\keranjang_penempatan;
use App\Models\detail_penempatan;
use App\Models\peminjaman;
use App\Models\keranjang_peminjaman;
use App\Models\detail_peminjaman;
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
    public function goSchedule()
    {
        return view('petugas.layout.schedule-training')->with([
            'title' => 'Jadwal Training',
            'active' => 'Jadwal Training',

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
        $detail_barang = DB::table('detail_penempatans')
            ->join('penempatans', 'detail_penempatans.no_penempatan', '=', 'penempatans.no_penempatan')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_penempatans.kode_barcode')
            ->select('penempatans.tanggal_penempatan','penempatans.lokasi_penempatan','penempatans.keterangan', 'detail_barangs.*')
            ->get();

        // dd($keranjang);


        return view('petugas.layout.transaksi.penempatan')->with([
            'title' => 'Penempatan',
            'active' => 'Penempatan',
            'barangs' => $detail_barang,
        ]);
    }
    public function goPenempatanTambah()
    {

        $noPengadaan = "PA-" . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis');
        $barangAll = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();
        $today = date('Y-m-d');
        $keranjang = DB::table('keranjang_penempatans')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'keranjang_penempatans.kode_barcode')
            ->get();

        return view('petugas.layout.transaksi.penempatan-tambah')->with([
            'title' => 'Buat Penempatan',
            'active' => 'Penempatan',
            'detail_barangs' => detail_barang::all(),
            'barangs' => $barangAll,
            'noPengadaan' => $noPengadaan,
            'today' => $today,
            'keranjangs' => $keranjang
        ]);
    }

    public function goPeminjaman() {

        $detail_peminjaman = DB::table('detail_peminjamans')
                                ->join('peminjamans', 'detail_peminjamans.no_peminjaman', '=', 'peminjamans.no_peminjaman')
                                ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_peminjamans.kode_barcode')
                                ->select('peminjamans.tanggal_peminjaman','peminjamans.id_pegawai','peminjamans.keterangan', 'detail_barangs.*')
                                ->get();

        return view('petugas.layout.transaksi.peminjaman')->with([
            'title' => 'Buat Peminjaman',
            'active' => 'Peminjaman',
            'data_peminjaman' => $detail_peminjaman
        ]);

    }


    public function goPeminjamanTambah()
    {

        $noPeminjaman = "PJ-" . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis');
        $barangAll = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();
        $today = date('Y-m-d');
        $keranjang = DB::table('keranjang_peminjamans')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'keranjang_peminjamans.kode_barcode')
            ->get();

        return view('petugas.layout.transaksi.peminjaman-tambah')->with([
            'title' => 'Buat Peminjaman',
            'active' => 'Peminjaman',
            'detail_barangs' => detail_barang::all(),
            'barangs' => $barangAll,
            'noPeminjaman' => $noPeminjaman,
            'today' => $today,
            'keranjangs' => $keranjang
        ]);
    }
    //end route view


    // Transaksi PENGADAAN
    public function select(Request $request)
    {

        $id = $request->input('no_barang');

        $no_last = DB::table('detail_barangs')
            ->select(DB::raw('id + 1 as noUrut'))
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get();

        if (!$no_last->isEmpty()) {
            $noUrut = $no_last[0]->noUrut;
            $floatValue = floatval($noUrut);
        }
        if ($no_last->isEmpty()) {
            $no_pengadaan_last = '01';
        } else {
            if ($noUrut < 10) {
                $no_pengadaan_last = '0' . $noUrut;
            } elseif ($noUrut < 100) {
                $no_pengadaan_last = $noUrut;
            } else {
                $no_pengadaan_last = '01';
            }
        }

        $data_barang = DB::table('barangs')->select('*')->where('no_barang', '=', $id)->first();

        $kode_barcode = Carbon::now()->setTimezone('Asia/Jakarta')->format('His') . $no_pengadaan_last;

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

        $validatedData['no_asset'] = $request->input('kode_awal') . '-' . $request->input('no_asset') . '-LC';

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
    // End End Transaksi PENGADAAN

    // Transaksi Penempatan
    public function addKeranjangPenempatan(Request $request)
    {
        $validatedData = $request->validate([
            'no_penempatan' => 'required',
            'kode_barcode' => 'required',
        ]);

        $no_barang = DB::table('detail_barangs')
            ->select('no_barang')
            ->where('kode_barcode', '=', $request->input('kode_barcode'))
            ->first();

        $validatedData['no_barang'] = $no_barang->no_barang;

        keranjang_penempatan::create($validatedData);

        $request->session()->flash('success', 'Barang masuk kedalam List Penempatan!');

        return redirect('/penempatan-tambah');
    }
    public function deleteKeranjangPenempatan(Request $request)
    {

        $nama_barang = DB::table('keranjang_penempatans')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'keranjang_penempatans.kode_barcode')
            ->where('keranjang_penempatans.no_penempatan', '=', $request->input('no_penempatan'))
            ->first();

        DB::table('keranjang_penempatans')
            ->where('no_penempatan', $request->input('no_penempatan'))->delete();

        $pesanFlash = "Barang (Merk: *{$nama_barang->merk} ) telah berhasil dihapus dari list!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/penempatan-tambah');
    }
    public function addPenempatan(Request $request)
    {
        $validatedData = $request->validate([
            'no_penempatan' => '',
            'lokasi_penempatan' => '',
            'keterangan' => '',
        ]);

        $validatedData['tanggal_penempatan'] = now()->format('Y-m-d');


        penempatan::create($validatedData);

        DB::statement("INSERT INTO detail_penempatans (no_penempatan, no_barang, kode_barcode)
         SELECT '$request->no_penempatan', no_barang, kode_barcode FROM keranjang_penempatans");

        DB::table('keranjang_penempatans')->truncate();

        $request->session()->flash('success', 'Data telah berhasil ditambahkan!');

        return redirect('/penempatan');
    }
    // End Transaksi Penempatan



    // Transaksi Peminjaman

    public function addKeranjangPeminjaman(Request $request)
    {
        $validatedData = $request->validate([
            'no_peminjaman' => 'required',
            'kode_barcode' => 'required',
        ]);

        $no_barang = DB::table('detail_barangs')
            ->select('no_barang')
            ->where('kode_barcode', '=', $request->input('kode_barcode'))
            ->first();

        $validatedData['no_barang'] = $no_barang->no_barang;

        keranjang_peminjaman::create($validatedData);

        $request->session()->flash('success', 'Barang masuk kedalam List Peminjaman!');

        return redirect('/peminjaman-tambah');
    }



    // END END Transaksi Peminjaman

}
