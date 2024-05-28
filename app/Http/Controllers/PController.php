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
use App\Models\mutasi;
use App\Models\keranjang_mutasi;
use App\Models\detail_mutasi;
use App\Models\maintenance;
use App\Models\penghapusan;
use App\Models\keranjang_penghapusan;
use App\Models\detail_penghapusan;
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
                'title' => 'Dashboard',
                'active' => 'Dashboard',
                'open' => 'no',
            ]
        );
    }

    public function goPetugas()
    {
        return view('petugas.layout.petugas')->with([
            'title' => 'Data Petugas',
            'active' => 'Data Petugas',
            'petugass' => User::all(),
            'open' => 'yes-1',
        ]);
    }

    public function goPegawai()
    {
        return view('petugas.layout.pegawai')->with([
            'title' => 'Data Pegawai',
            'active' => 'Data Pegawai',
            'pegawais' => pegawai::all(),
            'open' => 'yes-1',
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
            'open' => 'yes-1',
            // 'kategori_barang' => $kategori_barang,

        ]);
    }
    public function goKBarang()
    {
        return view('petugas.layout.kategoribrg')->with([
            'title' => 'Data Kategori Barang',
            'active' => 'Data Kategori Barang',
            'ktgr_brngs' => kategori_barang::all(),
            'open' => 'yes-1',
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
            'open' => 'yes-1',
        ]);
    }
    public function goTRuangan()
    {
        return view('petugas.layout.tiperuangan')->with([
            'title' => 'Data Tipe Ruangan',
            'active' => 'Data Tipe Ruangan',
            'tipe_ruangans' => tipe_ruangan::all(),
            'open' => 'yes-1',
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
            'open' => 'no',
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
            'open' => 'no',
        ]);
    }
    public function goSchedule()
    {
        return view('petugas.layout.schedule-training')->with([
            'title' => 'Jadwal Training',
            'active' => 'Jadwal Training',
            'open' => 'no',

        ]);
    }
    public function goProfile()
    {
        return view('petugas.layout.profile')->with([
            'title' => 'Profile',
            'active' => 'Profile',
            'open' => 'no',

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
            'total_harga' => $total_harga,
            'open' => 'yes-2',
        ]);
    }
    public function goPengadaanTambah()
    {

        $noPengadaan = "PD-" . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis');
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
            'today' => $today,
            'open' => 'yes-2',
        ]);
    }
    public function goPenempatan()
    {
        $detail_penempatan = DB::table('detail_penempatans')
            ->join('penempatans', 'detail_penempatans.no_penempatan', '=', 'penempatans.no_penempatan')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_penempatans.kode_barcode')
            ->select('penempatans.tanggal_penempatan', 'penempatans.lokasi_penempatan', 'penempatans.keterangan as keterangan_penempatan', 'detail_barangs.*')
            ->get();
        $detail_barang = DB::table('detail_barangs')
            ->select('*')
            ->get();

        // dd($keranjang);


        return view('petugas.layout.transaksi.penempatan')->with([
            'title' => 'Penempatan',
            'active' => 'Penempatan',
            'penempatans' => $detail_penempatan,
            'barangs' => $detail_barang,
            'open' => 'yes-2',
        ]);
    }
    public function goPenempatanTambah()
    {

        $noPenempatan = "PN-" . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis');
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
            'noPenempatan' => $noPenempatan,
            'today' => $today,
            'keranjangs' => $keranjang,
            'open' => 'yes-2',
        ]);
    }
    public function goMutasi()
    {
        $detail_mutasi = DB::table('detail_mutasis')
            ->join('mutasis', 'detail_mutasis.no_mutasi', '=', 'mutasis.no_mutasi')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_mutasis.kode_barcode')
            ->select('mutasis.tanggal_mutasi', 'mutasis.lokasi_terbaru', 'mutasis.keterangan as keterangan_mutasi', 'detail_barangs.*')
            ->get();
        $detail_barang = DB::table('detail_barangs')
            ->select('*')
            ->get();

        // dd($keranjang);


        return view('petugas.layout.transaksi.mutasi')->with([
            'title' => 'Mutasi',
            'active' => 'Mutasi',
            'mutasis' => $detail_mutasi,
            'barangs' => $detail_barang,
            'open' => 'yes-2',
        ]);
    }
    public function goMutasiTambah()
    {

        $noMutasi = "M-" . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis');
        $barangAll = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();
        $today = date('Y-m-d');
        $keranjang = DB::table('keranjang_mutasis')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'keranjang_mutasis.kode_barcode')
            // ->join('penempatans', 'penempatans.kode_barcode', '=', 'keranjang_mutasis.kode_barcode')
            ->get();

        return view('petugas.layout.transaksi.mutasi-tambah')->with([
            'title' => 'Buat Mutasi',
            'active' => 'Mutasi',
            'detail_barangs' => detail_barang::all(),
            'barangs' => $barangAll,
            'no_mutasi' => $noMutasi,
            'today' => $today,
            'keranjangs' => $keranjang,
            'open' => 'yes-2',
        ]);
    }

    public function goPeminjaman()
    {

        $detail_peminjaman = DB::table('detail_peminjamans')
            ->join('peminjamans', 'detail_peminjamans.no_peminjaman', '=', 'peminjamans.no_peminjaman')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_peminjamans.kode_barcode')
            ->select('peminjamans.tanggal_peminjaman', 'peminjamans.id_pegawai', 'peminjamans.keterangan', 'detail_barangs.*')
            ->get();

        return view('petugas.layout.transaksi.peminjaman')->with([
            'title' => 'Buat Peminjaman',
            'active' => 'Peminjaman',
            'data_peminjaman' => $detail_peminjaman,
            'open' => 'yes-2',
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
            'keranjangs' => $keranjang,
            'open' => 'yes-2',
        ]);
    }

    public function goMaintenance()
    {
        $detail_maintenance = DB::table('maintenances')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
            ->select('*','maintenances.status as status_maintenance','maintenances.keterangan as keterangan_maintenance')
            ->get();
        $detail_barang = DB::table('detail_barangs')
            ->select('*')
            ->get();

        // dd($keranjang);


        return view('petugas.layout.transaksi.maintenance')->with([
            'title' => 'Maintenance',
            'active' => 'Maintenance',
            'maintenances' => $detail_maintenance,
            'barangs' => $detail_barang,
            'open' => 'yes-2',
        ]);
    }
    public function goMaintenanceTambah()
    {

        $noMaintenance = "MA-" . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis');
        $barangAll = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();
        $today = date('Y-m-d');
        // $keranjang = DB::table('keranjang_mutasis')
        //     ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'keranjang_mutasis.kode_barcode')
        //     // ->join('penempatans', 'penempatans.kode_barcode', '=', 'keranjang_mutasis.kode_barcode')
        //     ->get();

        return view('petugas.layout.transaksi.maintenance-tambah')->with([
            'title' => 'Buat Maintenance',
            'active' => 'Maintenance',
            'detail_barangs' => detail_barang::all(),
            'barangs' => $barangAll,
            'no_mutasi' => $noMaintenance,
            'today' => $today,
            'open' => 'yes-2',
            // 'keranjangs' => $keranjang
        ]);
    }
    public function goPenghapusan()
    {
        $detail_penghapusan = DB::table('detail_penghapusans')
            ->join('penghapusans', 'detail_penghapusans.no_penghapusan', '=', 'penghapusans.no_penghapusan')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_penghapusans.kode_barcode')
            ->select('penghapusans.tanggal_penghapusan', 'penghapusans.jenis_penghapusan', 'penghapusans.keterangan as keterangan_penghapusan', 'detail_barangs.*')
            ->get();
        $detail_barang = DB::table('detail_barangs')
            ->select('*')
            ->get();

        // dd($keranjang);


        return view('petugas.layout.transaksi.penghapusan')->with([
            'title' => 'Penghapusan',
            'active' => 'Penghapusan',
            'penghapusans' => $detail_penghapusan,
            'barangs' => $detail_barang,
            'open' => 'yes-2',
        ]);
    }
    public function goPenghapusanTambah()
    {

        $noPenghapusan = "PH-" . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis');
        $barangAll = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();
        $today = date('Y-m-d');
        $keranjang = DB::table('keranjang_penghapusans')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'keranjang_penghapusans.kode_barcode')
            ->get();

        return view('petugas.layout.transaksi.penghapusan-tambah')->with([
            'title' => 'Buat Penghapusan',
            'active' => 'Penghapusan',
            'detail_barangs' => detail_barang::all(),
            'barangs' => $barangAll,
            'noPenghapusan' => $noPenghapusan,
            'today' => $today,
            'keranjangs' => $keranjang,
            'open' => 'yes-2',
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
            'no_pengadaan' => 'nullable',
            'no_barang' => 'required',
            'kode_barcode' => 'required',
            'no_asset' => 'required',
            'merk' => 'required|max:255',
            'jenis_pengadaan' => 'required',
            'spesifikasi' => 'required|max:255',
            'kondisi' => 'required',
            'status' => 'required',
            'harga' => 'required|numeric',
            'foto_barang' => '',
            'keterangan' => 'required|max:255',
        ]);


        $validatedData['no_asset'] = $request->input('kode_awal') . '-' . $request->input('no_asset') . '-LC';

        if($request->foto_barang == null) {
            $validatedData['foto_barang'] = '';


        } else {
            $validatedData['foto_barang'] = $request->file('foto_barang')->store('fotobarang');
        }


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

        $kode_barcodes = DB::table('keranjang_penempatans')->select('kode_barcode')->get();

        penempatan::create($validatedData);

        $validatedDataStatus['status'] = "Sudah Ditempatkan";

        // dd($validatedDataStatus['status']);

        foreach ($kode_barcodes as $kode_barcode) {
            DB::table('detail_barangs')
                ->where('kode_barcode', $kode_barcode->kode_barcode)
                ->update($validatedDataStatus);
        }

        DB::statement("INSERT INTO detail_penempatans (no_penempatan, no_barang, kode_barcode)
         SELECT '$request->no_penempatan', no_barang, kode_barcode FROM keranjang_penempatans");

        DB::table('keranjang_penempatans')->truncate();


        $request->session()->flash('success', 'Data telah berhasil ditambahkan!');

        return redirect('/penempatan');
    }
    //End Transaksi Penempatan
    public function addKeranjangMutasi(Request $request)
    {
        $validatedData = $request->validate([
            'no_mutasi' => 'required',
            'kode_barcode' => 'required',
        ]);

        $no_barang = DB::table('detail_barangs')
            ->select('no_barang')
            ->where('kode_barcode', '=', $request->input('kode_barcode'))
            ->first();

        $validatedData['no_barang'] = $no_barang->no_barang;

        keranjang_mutasi::create($validatedData);

        $request->session()->flash('success', 'Barang masuk kedalam List Mutasi!');

        return redirect('/mutasi-tambah');
    }
    public function deleteKeranjangMutasi(Request $request)
    {

        $nama_barang = DB::table('keranjang_mutasis')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'keranjang_mutasis.kode_barcode')
            ->where('keranjang_mutasis.no_mutasi', '=', $request->input('no_mutasi'))
            ->first();

        DB::table('keranjang_mutasis')
            ->where('no_mutasi', $request->input('no_mutasi'))->delete();

        $pesanFlash = "Barang (Merk: *{$nama_barang->merk} ) telah berhasil dihapus dari list!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/mutasi-tambah');
    }
    public function addMutasi(Request $request)
    {
        $validatedData = $request->validate([
            'no_mutasi' => '',
            'lokasi_terbaru' => '',
            'keterangan' => '',
        ]);

        $validatedData['tanggal_mutasi'] = now()->format('Y-m-d');

        // $kode_barcodes = DB::table('keranjang_mutasis')->select('kode_barcode')->get();

        mutasi::create($validatedData);

        // $validatedDataStatus['status'] = "Sudah Ditempatkan di " . $request->input('lokasi_penempatan');

        // dd($validatedDataStatus['status']);

        // foreach ($kode_barcodes as $kode_barcode) {
        //     DB::table('detail_barangs')
        //         ->where('kode_barcode', $kode_barcode->kode_barcode)
        //         ->update($validatedDataStatus);
        // }

        DB::statement("INSERT INTO detail_mutasis (no_mutasi, no_barang, kode_barcode)
         SELECT '$request->no_mutasi', no_barang, kode_barcode FROM keranjang_mutasis");

        DB::table('keranjang_mutasis')->truncate();


        $request->session()->flash('success', 'Data telah berhasil ditambahkan!');

        return redirect('/mutasi');
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

    //Transaksi Maintenance
    public function getBarangByBarcode(Request $request)
    {
        $kode_barcode = $request->input('kode_barcode');
        $barang = DB::table('detail_barangs')
            ->select('*')
            ->join('barangs', 'barangs.no_barang', '=', 'detail_barangs.no_barang')
            ->where('detail_barangs.kode_barcode', '=', $kode_barcode)
            ->first();

        // dd($barang);

        if ($barang) {
            $merk_barang = $barang->nama_barang . ' , ' . $barang->merk . ' , ' . $barang->spesifikasi;
            return response()->json(['status' => 'success', 'data' => $barang, 'merk_barang' => $merk_barang]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Barang not found'], 404);
        }
    }
    public function addMaintenance(Request $request)
    {
        $validatedData = $request->validate([
            'no_maintenance' => '',
            'biaya' => 'required|numeric',
            'keterangan' => 'required',
            'kode_barcode' => 'required',
        ]);

        $no_barang = DB::table('detail_barangs')->select('no_barang')->where('kode_barcode','=',$request->kode_barcode)->first();

        $validatedData['tanggal_maintenance'] = now()->format('Y-m-d');
        
        $validatedData['no_barang'] = $no_barang->no_barang;
        $validatedData['status'] = "Sedang Diproses";
        $validatedData['user_id'] = auth()->user()->id;
        
        maintenance::create($validatedData);

        // $validatedDataStatus['status'] = "Sudah Ditempatkan di " . $request->input('lokasi_penempatan');

        // dd($validatedDataStatus['status']);

        // foreach ($kode_barcodes as $kode_barcode) {
        //     DB::table('detail_barangs')
        //         ->where('kode_barcode', $kode_barcode->kode_barcode)
        //         ->update($validatedDataStatus);
        // }

        // DB::statement("INSERT INTO detail_mutasis (no_mutasi, no_barang, kode_barcode)
        //  SELECT '$request->no_mutasi', no_barang, kode_barcode FROM keranjang_mutasis");

        // DB::table('keranjang_mutasis')->truncate();


        $request->session()->flash('success', 'Data telah berhasil ditambahkan!');

        return redirect('/maintenance');
    }
    public function confirmMaintenance(Request $request, ruangan $ruangan)
    {
        $validatedData['tanggal_selesai'] = now()->format('Y-m-d');
        $validatedData['status'] = "Selesai Maintenance";


        DB::table('maintenances')
            ->where('no_maintenance', $request->input('no_maintenance'))
            ->update($validatedData);
            

        $request->session()->flash('success', 'Maintenance telah dikonfirmasi selesai!');

        return redirect('/maintenance');
    }
    //End Transaksi Maintenance

    // Transaksi Penghapusan
    public function addKeranjangPenghapusan(Request $request)
    {
        $validatedData = $request->validate([
            'no_penghapusan' => 'required',
            'kode_barcode' => 'required',
        ]);

        $no_barang = DB::table('detail_barangs')
            ->select('no_barang')
            ->where('kode_barcode', '=', $request->input('kode_barcode'))
            ->first();

        $validatedData['no_barang'] = $no_barang->no_barang;

        keranjang_penghapusan::create($validatedData);

        $request->session()->flash('success', 'Barang masuk kedalam List Penghapusan!');

        return redirect('/penghapusan-tambah');
    }
    public function deleteKeranjangPenghapusan(Request $request)
    {

        $nama_barang = DB::table('keranjang_penghapusans')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'keranjang_penghapusans.kode_barcode')
            ->where('keranjang_penghapusans.no_penghapusan', '=', $request->input('no_penghapusan'))
            ->first();

        DB::table('keranjang_penghapusans')
            ->where('no_penghapusan', $request->input('no_penghapusan'))->delete();

        $pesanFlash = "Barang (Merk: *{$nama_barang->merk} ) telah berhasil dihapus dari list!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/penghapusan-tambah');
    }
    public function addPenghapusan(Request $request)
    {
        $validatedData = $request->validate([
            'no_penghapusan' => '',
            'jenis_penghapusan' => '',
            'keterangan' => '',
        ]);

        $validatedData['tanggal_penghapusan'] = now()->format('Y-m-d');

        $kode_barcodes = DB::table('keranjang_penghapusans')->select('kode_barcode')->get();

        penghapusan::create($validatedData);

        $validatedDataStatus['status'] = "Sudah Dihapus";

        // dd($validatedDataStatus['status']);

        foreach ($kode_barcodes as $kode_barcode) {
            DB::table('detail_barangs')
                ->where('kode_barcode', $kode_barcode->kode_barcode)
                ->update($validatedDataStatus);
        }

        DB::statement("INSERT INTO detail_penghapusans (no_penghapusan, no_barang, kode_barcode)
         SELECT '$request->no_penghapusan', no_barang, kode_barcode FROM keranjang_penghapusans");

        DB::table('keranjang_penghapusans')->truncate();


        $request->session()->flash('success', 'Data telah berhasil ditambahkan!');

        return redirect('/penghapusan');
    }
    //End Transaksi Penghapusan

}

