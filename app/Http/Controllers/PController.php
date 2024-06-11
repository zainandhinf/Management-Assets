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
use App\Models\departemen;
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
    public function goDepartemen()
    {
        return view('petugas.layout.departemen')->with([
            'title' => 'Data Departemen',
            'active' => 'Data Departemen',
            'departemens' => departemen::all(),
            'open' => 'yes-1',
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


        // dd($detail_barang);


        return view('petugas.layout.transaksi.pengadaan')->with([
            'title' => 'Pengadaan',
            'active' => 'Pengadaan',
            'barangs' => $detail_barang,
            'keranjangs' => $keranjangs,
            'total_harga' => $total_harga,
            'pengadaans' => pengadaan::all(),
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
        $details = DB::table('detail_barangs')
            ->join('barangs', 'barangs.no_barang', '=', 'detail_barangs.no_barang')
            ->select('detail_barangs.*', 'barangs.nama_barang')
            ->get();

        return view('petugas.layout.transaksi.pengadaan-tambah')->with([
            'title' => 'Buat Pengadaan',
            'active' => 'Pengadaan',
            'detail_barangs' => detail_barang::all(),
            'barangs' => $barangAll,
            'noPengadaan' => $noPengadaan,
            'today' => $today,
            'open' => 'yes-2',
            'details' => $details,

        ]);
    }
    public function goPenempatan()
    {

        $detail_barang = DB::table('detail_barangs')
            ->select('*')
            ->get();

        // dd($keranjang);
        $data_penempatans = DB::table('penempatans')->select('*')->get();

        $penempatans = DB::table('penempatans')
            ->join('detail_penempatans', 'detail_penempatans.no_penempatan', '=', 'penempatans.no_penempatan')
            ->select('penempatans.*', 'detail_penempatans.kode_barcode')
            ->get();


        return view('petugas.layout.transaksi.penempatan')->with([
            'title' => 'Penempatan',
            'active' => 'Penempatan',
            'penempatans' => $penempatans,
            'data_penempatans' => $data_penempatans,
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
        $detail_barang = DB::table('detail_barangs')
            ->select('*')
            ->get();

        // dd($keranjang);

        $mutasis = DB::table('mutasis')
            // ->join('detail_mutasis', 'detail_mutasis.no_mutasi', '=', 'mutasis.no_mutasi')
            ->select('*')
            ->get();

        // $detail_mutasi = DB::table('detail_mutasis')
        //     ->join('mutasis', 'detail_mutasis.no_mutasi', '=', 'mutasis.no_mutasi')
        //     ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_mutasis.kode_barcode')
        //     ->select('mutasis.tanggal_mutasi', 'mutasis.no_ruangan', 'mutasis.keterangan as keterangan_mutasi', 'detail_barangs.*')
        //     ->get();

        // dd($keranjang);


        return view('petugas.layout.transaksi.mutasi')->with([
            'title' => 'Mutasi',
            'active' => 'Mutasi',
            'mutasis' => $mutasis,
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

    //PEMINJAMAN START

    public function goPeminjaman()
    {

        $detail_peminjaman = DB::table('detail_peminjamans')
            ->join('peminjamans', 'detail_peminjamans.no_peminjaman', '=', 'peminjamans.no_peminjaman')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_peminjamans.kode_barcode')
            ->select('peminjamans.no_peminjaman', 'peminjamans.tanggal_peminjaman', 'peminjamans.tanggal_kembali', 'peminjamans.status_peminjaman', 'peminjamans.id_pegawai', 'peminjamans.keterangan', 'detail_barangs.*')
            ->get();

        // dd($detail_peminjaman);

        $detail_barangs = DB::table('detail_barangs')
            ->select('*')
            ->get();

        return view('petugas.layout.transaksi.peminjaman')->with([
            'title' => 'Buat Peminjaman',
            'active' => 'Peminjaman',
            'data_peminjaman' => $detail_peminjaman,
            'open' => 'yes-2',
            'barangs' => $detail_barangs
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

    //PEMINJAMAN END END


    public function goMaintenance()
    {
        $detail_maintenance = DB::table('maintenances')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
            ->select('*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance')
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
        // $detail_penghapusan = DB::table('detail_penghapusans')
        //     ->join('penghapusans', 'detail_penghapusans.no_penghapusan', '=', 'penghapusans.no_penghapusan')
        //     ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_penghapusans.kode_barcode')
        //     ->select('penghapusans.tanggal_penghapusan', 'penghapusans.jenis_penghapusan', 'penghapusans.keterangan as keterangan_penghapusan', 'detail_barangs.*')
        //     ->get();
        $detail_barang = DB::table('detail_barangs')
            ->select('*')
            ->get();

        $penghapusans = DB::table('penghapusans')
            ->join('detail_penghapusans', 'detail_penghapusans.no_penghapusan', '=', 'penghapusans.no_penghapusan')
            ->select('*')
            ->get();
        // dd($keranjang);


        return view('petugas.layout.transaksi.penghapusan')->with([
            'title' => 'Penghapusan',
            'active' => 'Penghapusan',
            'penghapusans' => $penghapusans,
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

        $cek = DB::table('barangs')->where('no_barang', '=', $id)->count();

        if ($cek > 0) {


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
                'open' => 'yes-2',
            ]);

        } else {

            $error = strtoupper($request->input('no_barang'));

            $pesanFlash = "Barang dengan kode ($error) Tidak ditemukan!";

            $request->session()->flash('error', $pesanFlash);

            return redirect()->back();

        }



    }
    public function addKeranjang(Request $request)
    {

        $na = $request->input('kode_awal') . '-' . $request->input('no_asset') . '-LC';
        $cek = DB::table('keranjang_pengadaans')
            ->where('no_asset', '=', $na)
            ->count();
        // dd($cek);

        if ($cek > 0) {
            $a = $request->no_asset;
            $pesanFlash = "No. Asset: " . $a . " Sudah terdaftar! Pilih Nomor lain.";
            $request->session()->flash('error', $pesanFlash);

            return redirect('/pengadaan-tambah');

        } else {


            $validatedData = $request->validate([
                'no_pengadaan' => 'nullable',
                'no_barang' => 'required',
                'kode_barcode' => 'required',
                'no_asset' => 'required|unique:keranjang_pengadaans',
                'nomor_kodifikasi' => 'required',
                'merk' => 'required|max:255',
                'jenis_pengadaan' => 'required',
                'spesifikasi' => 'required|max:255',
                'kondisi' => 'required',
                'status' => 'required',
                'harga' => 'required',
                'foto_barang' => '',
                'keterangan' => 'max:255',
            ]);

            $harga = str_replace('.', '', $request->input('harga'));
            $validatedData['harga'] = intval($harga);
            $validatedData['keterangan'] = 'Pengadaan barang untuk pendataan.';

            $validatedData['no_asset'] = $request->input('kode_awal') . '-' . $request->input('no_asset') . '-LC';

            if ($request->foto_barang == null) {
                $validatedData['foto_barang'] = '';


            } else {
                $validatedData['foto_barang'] = $request->file('foto_barang')->store('fotobarang');
            }


            keranjang_pengadaan::create($validatedData);

            $request->session()->flash('success', 'Barang masuk kedalam List Pengadaan!');

            return redirect('/pengadaan');
        }

    }

    public function deleteKeranjang(Request $request)
    {

        $nama_barang = DB::table('keranjang_pengadaans')
            ->select('*')
            ->where('id', '=', $request->input('id_keranjang'))
            ->get();

        DB::table('keranjang_pengadaans')
            ->where('id', $request->input('id_keranjang'))->delete();

        $pesanFlash = "Barang (Merk: *{$nama_barang[0]->merk} ) telah berhasil dihapus dari Keranjang!";

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

        DB::statement("INSERT INTO detail_barangs (no_pengadaan, no_barang, kode_barcode, no_asset, nomor_kodifikasi, merk, jenis_pengadaan, spesifikasi, kondisi, status, harga, keterangan)
         SELECT '$no_pengadaan', no_barang, kode_barcode, no_asset, nomor_kodifikasi, merk, jenis_pengadaan, spesifikasi, kondisi, status, harga, keterangan FROM keranjang_pengadaans");

        DB::table('keranjang_pengadaans')->truncate();

        $request->session()->flash('success', 'Pengadaan BERHASIL Dilakukan!');

        return redirect('/pengadaan');
    }
    public function deleteDetail(Request $request)
    {
        // dd($request);


        $cek1 = DB::table('keranjang_penempatans')
                        ->where('kode_barcode', '=', $request->kode_barcode)
                        ->count();
                        // dd($cek1);
        $cek2 = DB::table('keranjang_mutasis')
                        ->where('kode_barcode', '=', $request->kode_barcode)
                        ->count();
                        // dd($cek2);
        $cek3 = DB::table('keranjang_peminjamans')
                        ->where('kode_barcode', '=', $request->kode_barcode)
                        ->count();
                        dd($cek3);
        $cek4 = DB::table('keranjang_penghapusans')
                        ->where('kode_barcode', '=', $request->kode_barcode)
                        ->count();
                        // dd($cek1);
        if ($cek1 > 0) {

            // return redirect('/ljdadh');
              $brg_cek1 = DB::table('detail_barangs')
                        ->leftjoin('keranjang_penempatans', 'keranjang_penempatans.kode_barcode', '=', 'detail_barangs.kode_barcode')
                        ->where('detail_barangs.kode_barcode', '=', $request->kode_barcode)
                        ->select('detail_barangs.merk', 'detail_barangs.kode_barcode')
                        ->first();



            $pesanFlash = "GAGAL Menghapus! Barang (Merk: *{$brg_cek1->merk}, barcode: *{$brg_cek1->kode_barcode} ) sedang berada di List Penempatan!";

            $request->session()->flash('error', $pesanFlash);

            return redirect('/pengadaan-tambah');

        } else if($cek2 > 0){

            $brg_cek1 = DB::table('detail_barangs')
                        ->leftjoin('keranjang_mutasis', 'keranjang_mutasis.kode_barcode', '=', 'detail_barangs.kode_barcode')
                        ->where('detail_barangs.kode_barcode', '=', $request->kode_barcode)
                        ->select('detail_barangs.merk', 'detail_barangs.kode_barcode')
                        ->first();



            $pesanFlash = "GAGAL Menghapus! Barang (Merk: *{$brg_cek1->merk}, barcode: *{$brg_cek1->kode_barcode} ) sedang berada di List Mutasi!";

            $request->session()->flash('error', $pesanFlash);

            return redirect('/pengadaan-tambah');

        } else if($cek3 > 0) {

            $brg_cek1 = DB::table('detail_barangs')
            ->leftjoin('keranjang_peminjamans', 'keranjang_peminjamans.kode_barcode', '=', 'detail_barangs.kode_barcode')
            ->where('detail_barangs.kode_barcode', '=', $request->kode_barcode)
            ->select('detail_barangs.merk', 'detail_barangs.kode_barcode')
            ->first();

            $pesanFlash = "GAGAL Menghapus! Barang (Merk: *{$brg_cek1->merk}, barcode: *{$brg_cek1->kode_barcode} ) sedang berada di List Peminjaman!";

            $request->session()->flash('error', $pesanFlash);

            return redirect('/pengadaan-tambah');

        } else if($cek4 > 0) {

            $brg_cek1 = DB::table('detail_barangs')
            ->leftjoin('keranjang_penghapusans', 'keranjang_penghapusans.kode_barcode', '=', 'detail_barangs.kode_barcode')
            ->where('detail_barangs.kode_barcode', '=', $request->kode_barcode)
            ->select('detail_barangs.merk', 'detail_barangs.kode_barcode')
            ->first();

            $pesanFlash = "GAGAL Menghapus! Barang (Merk: *{$brg_cek1->merk}, barcode: *{$brg_cek1->kode_barcode} ) sedang berada di List Barang yang akan Dihapus!";

            $request->session()->flash('error', $pesanFlash);

            return redirect('/pengadaan-tambah');



        } else {


        $nama_barang = DB::table('detail_barangs')
            ->select('merk')
            ->where('id', '=', $request->input('id_detail'))
            ->get();

        DB::table('detail_barangs')->where('id', $request->input('id_detail'))->delete();

        $pesanFlash = "Barang (Merk: *{$nama_barang[0]->merk} ) telah BERHASIL dihapus!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/pengadaan');

        }

    }
    public function deletePengadaan(Request $request)
    {
        // $np = DB::table('detil_barangs')
        // ->where('no_pengadaan', '=', $request->no_pengadaan)
        // ->select('no_pengadaan')
        // ->get();
        // dd($request);

        $a = DB::table('pengadaans')
                        ->join('detail_barangs', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
                        ->where('pengadaans.no_pengadaan', '=', $request->no_pengadaan)
                        ->select('detail_barangs.kode_barcode')
                        ->get();

                        foreach ($a as $a) {

                            dd($a->kode_barcode);
                            $cek1 = DB::table('keranjang_penempatans')
                        ->where('kode_barcode', '=', $a->kode_barcode)
                        ->count();
                        dd($cek1);
                        $cek2 = DB::table('keranjang_mutasis')
                                        ->where('kode_barcode', '=', $a->kode_barcode)
                                        ->count();
                                        // dd($cek2);
                        $cek3 = DB::table('keranjang_peminjamans')
                                        ->where('kode_barcode', '=', $a->kode_barcode)
                                        ->count();
                                        // dd($cek3);
                        $cek4 = DB::table('keranjang_penghapusans')
                                        ->where('kode_barcode', '=', $a->kode_barcode)
                                        ->count();
                                        // dd($cek1);
                        // dd($cek1);

                        }




        $a = DB::table('barangs')
                    ->join('detail_barangs', 'detail_barangs.');

        // foreach ($np as $np) {
        $keyword = $request->konfirmasi;

        if ($keyword == "KONFIRMASI") {

            DB::table('detail_barangs')
                ->where('no_pengadaan', $request->no_pengadaan)
                ->delete();
            // }
            // $np = DB::table('detail_barangs')
            //     ->where('no_pengadaan', '=', $request->input('no_pengadaan'))
            //     ->select('*')
            //     ->first();
            // dd($request->input('no_pengadaan'));

            DB::table('detail_barangs')->where('no_pengadaan', $request->input('no_pengadaan'))->delete();
            DB::table('pengadaans')->where('no_pengadaan', $request->input('no_pengadaan'))->delete();

            $pesanFlash = "Semua Barang (No. Pengadaan: *{$request->no_pengadaan} ) telah berhasil dihapus!";

            $request->session()->flash('error', $pesanFlash);

            return redirect('/pengadaan');
        } else {

            $pesanFlash = "Keyword tidak Cocok! GAGAL Menghapus Data..";

            $request->session()->flash('error', $pesanFlash);

            return redirect('/pengadaan');


        }

    }

    // End End Transaksi PENGADAAN

    // Transaksi Penempatan
    public function addKeranjangPenempatan(Request $request)
    {
        $cek1 = DB::table('keranjang_penempatans')->where('kode_barcode', '=', $request->kode_barcode)->first();
        $cek2 = DB::table('detail_penempatans')->where('kode_barcode', '=', $request->kode_barcode)->first();
        $cek3 = DB::table('detail_barangs')->where('kode_barcode', '=', $request->kode_barcode)->first();

        if ($cek1 == null) {
            if ($cek3->status == "Sudah Dihapus") {
                $request->session()->flash('error', 'Barang sudah dihapus!');

                return redirect('/penempatan-tambah');
            } else {
                if ($cek2 == null) {
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
                } else {
                    $request->session()->flash('error', 'Barang sudah ditempatkan!');

                    return redirect('/penempatan-tambah');
                }
            }
        } else {
            $request->session()->flash('error', 'Barang sudah ada di List Penempatan!');

            return redirect('/penempatan-tambah');
        }


    }
    public function deleteKeranjangPenempatan(Request $request)
    {

        $nama_barang = DB::table('keranjang_penempatans')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'keranjang_penempatans.kode_barcode')
            ->where('keranjang_penempatans.no_penempatan', '=', $request->input('no_penempatan'))
            ->first();

        DB::table('keranjang_penempatans')
            ->where('no_penempatan', $request->input('no_penempatan'))->delete();

        $pesanFlash = "Barang (Merk: *{$nama_barang->merk} ) telah berhasil dihapus dari list Penempatan!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/penempatan-tambah');
    }
    public function addPenempatan(Request $request)
    {

        $cekKeranjang = DB::table('keranjang_penempatans')
            ->select('*')
            ->count();

        if ($cekKeranjang == 0) {

            $request->session()->flash('error', 'List Penempatan KOSONG! Harap isi terlebih dahulu..');

            return redirect('/penempatan-tambah');

        } else {


            $cek = DB::table('penempatans')
                ->where('no_penempatan', '=', $request->no_penempatan)
                ->count();

            // dd($cek);

            if ($cek > 0) {
                $pesanFlash = "Data dengan (No. Penempatan: *{$request->no_penempatan} ) Sudah ada sebelumnya!";

                $request->session()->flash('error', $pesanFlash);

                return redirect('/penempatan-tambah');
            } else {


                $validatedData = $request->validate([
                    'no_penempatan' => '',
                    'no_ruangan' => '',
                    'user_id' => '',
                    'keterangan' => 'nullable',
                ]);

                if ($request->keterangan == null) {

                    $validatedData['keterangan'] = 'Penempatan baru.';

                }

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


                $request->session()->flash('success', 'Penempatan Baru telah berhasil ditambahkan!');

                return redirect('/penempatan');
            }

        }

    }


    public function deleteDetailPenempatan(Request $request)
    {


        // $cek1 = DB::table('keranjang_penempatans')
        //                 ->where('kode_barcode', '=', $request->kode_barcode)
        //                 ->count();
        //                 // dd($cek1);
        $cek2 = DB::table('keranjang_mutasis')
                        ->where('kode_barcode', '=', $request->kode_barcode)
                        ->count();
                        // dd($cek2);
        $cek3 = DB::table('keranjang_peminjamans')
                        ->where('kode_barcode', '=', $request->kode_barcode)
                        ->count();
                        // dd($cek3);
        $cek4 = DB::table('keranjang_penghapusans')
                        ->where('kode_barcode', '=', $request->kode_barcode)
                        ->count();
                        // dd($cek1);
        if ($cek2 > 0) {

            $brg_cek1 = DB::table('detail_barangs')
            ->leftjoin('keranjang_peminjamans', 'keranjang_peminjamans.kode_barcode', '=', 'detail_barangs.kode_barcode')
            ->where('detail_barangs.kode_barcode', '=', $request->kode_barcode)
            ->select('detail_barangs.merk', 'detail_barangs.kode_barcode')
            ->first();

            $pesanFlash = "GAGAL Menghapus! Barang (Merk: *{$brg_cek1->merk}, barcode: *{$brg_cek1->kode_barcode} ) sedang berada di List Peminjaman!";

            $request->session()->flash('error', $pesanFlash);

            return redirect('/penempatan');

        } else if ($cek3 > 0) {

            $brg_cek1 = DB::table('detail_barangs')
            ->leftjoin('keranjang_peminjamans', 'keranjang_peminjamans.kode_barcode', '=', 'detail_barangs.kode_barcode')
            ->where('detail_barangs.kode_barcode', '=', $request->kode_barcode)
            ->select('detail_barangs.merk', 'detail_barangs.kode_barcode')
            ->first();

            $pesanFlash = "GAGAL Menghapus! Barang (Merk: *{$brg_cek1->merk}, barcode: *{$brg_cek1->kode_barcode} ) sedang berada di List Peminjaman!";

            $request->session()->flash('error', $pesanFlash);

            return redirect('/penempatan');
        } else if ($cek4 > 0) {

            $brg_cek1 = DB::table('detail_barangs')
            ->leftjoin('keranjang_penghapusans', 'keranjang_penghapusans.kode_barcode', '=', 'detail_barangs.kode_barcode')
            ->where('detail_barangs.kode_barcode', '=', $request->kode_barcode)
            ->select('detail_barangs.merk', 'detail_barangs.kode_barcode')
            ->first();

            $pesanFlash = "GAGAL Menghapus! Barang (Merk: *{$brg_cek1->merk}, barcode: *{$brg_cek1->kode_barcode} ) sedang berada di List Barang yang akan Dihapus!";

            $request->session()->flash('error', $pesanFlash);

            return redirect('/penempatan');

        } else {



        $data = DB::table('detail_penempatans')
            // ->select('merk')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_penempatans.kode_barcode')
            ->where('detail_barangs.kode_barcode', '=', $request->input('kode_barcode'))
            ->select('detail_barangs.merk', 'detail_penempatans.*')
            ->first();

        // dd($data);

        $room = DB::table('penempatans')
            ->join('detail_penempatans', 'detail_penempatans.no_penempatan', '=', 'penempatans.no_penempatan')
            ->where('penempatans.no_penempatan', '=', $request->no_penempatan)
            ->select('penempatans.no_ruangan')
            ->first();

        $roomName = DB::table('ruangans')
            ->join('penempatans', 'penempatans.no_ruangan', '=', 'ruangans.no_ruangan')
            ->where('ruangans.no_ruangan', '=', $room->no_ruangan)
            ->select('ruangans.ruangan')
            ->first();
        // dd($roomName);

        DB::table('detail_penempatans')->where('kode_barcode', $request->input('kode_barcode'))->delete();

        $updateStatus['status'] = "Belum Ditempatkan";


        DB::table('detail_barangs')
            ->where('kode_barcode', $request->kode_barcode)
            ->update($updateStatus);

        $pesanFlash = "Barang (Merk: *{$data->merk} ) BERHASIL dihapus dari Ruangan: {$roomName->ruangan}!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/penempatan');

    }

    }

    public function deletePenempatan(Request $request)
    {
        // dd($request);
        // return redirect('/delete-penempatan');
        // $np = DB::table('detil_barangs')
        // ->where('no_pengadaan', '=', $request->no_pengadaan)
        // ->select('no_pengadaan')
        // ->get();

        $detail = DB::table('detail_penempatans')
        // ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_penempatans.kode_barcode')
        ->where('no_penempatan', '=', $request->no_penempatan)
        ->select('kode_barcode')
        ->get();

        // dd($detail);

        // $detail = DB::table('detail_barangs')
        //                     ->join('detail_penempatans', 'detail_penempatans.kode_barcode', '=', 'detail_barangs.kode_barcode')
        //                     ->where('detail_barangs.kode_barcode', '=', $a->kode_barcode)
        //                     ->select('detail_barangs.kode_barcode')
        //                     ->get();
        // foreach ($np as $np) {
        $keyword = $request->konfirmasi;

        if ($keyword == "KONFIRMASI") {

            // DB::table('detail_barangs')
            //     ->where('no_pengadaan', $request->no_pengadaan)
            //     ->delete();
            // }
            // $np = DB::table('detail_barangs')
            //     ->where('no_pengadaan', '=', $request->input('no_pengadaan'))
            //     ->select('*')
            //     ->first();
            // dd($request->input('no_pengadaan'));

            // dd($detail);
        DB::table('detail_penempatans')->where('no_penempatan', $request->input('no_penempatan'))->delete();
        DB::table('penempatans')->where('no_penempatan', $request->input('no_penempatan'))->delete();

            $updateStatus['status'] = "Belum Ditempatkan";


            foreach ($detail as $kode_barcode) {
                DB::table('detail_barangs')
                        ->where('kode_barcode', '=', $kode_barcode->kode_barcode)
                        ->update($updateStatus);
            }

            $pesanFlash = "Semua Penempatan (No. Penempatan: *{$request->no_penempatan} ) telah berhasil dihapus!";

            $request->session()->flash('error', $pesanFlash);

            return redirect('/penempatan');
        } else {

            $pesanFlash = "Keyword tidak Cocok! GAGAL Menghapus Data..";

            $request->session()->flash('error', $pesanFlash);

            return redirect('/penempatan');


        }

    }
    //End Transaksi Penempatan
    public function addKeranjangMutasi(Request $request)
    {
        $cek1 = DB::table('keranjang_mutasis')->where('kode_barcode', '=', $request->kode_barcode)->first();
        $cek2 = DB::table('detail_barangs')->where('kode_barcode', '=', $request->kode_barcode)->first();

        if ($cek1 == null) {
            if ($cek2->status == "Belum Ditempatkan") {
                $request->session()->flash('error', 'Barang belum ditempatkan! Pilih barang yang sudah ditempatkan sebelumnya..');

                return redirect('/mutasi-tambah');
            } else if ($cek2->status == "Sudah Dihapus") {
                $request->session()->flash('error', 'Barang sudah dihapus!');

                return redirect('/mutasi-tambah');
            } else {
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
        } else {
            $request->session()->flash('error', 'Barang sudah ada di List Mutasi!');

            return redirect('/mutasi-tambah');
        }

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

        $keranjangs = DB::table('keranjang_mutasis')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'keranjang_mutasis.kode_barcode')
            ->get();
        // dd($keranjangs);
        foreach ($keranjangs as $keranjang) {
            $penempatan = DB::table('detail_penempatans')
                ->join('penempatans', 'penempatans.no_penempatan', '=', 'detail_penempatans.no_penempatan')
                ->where('detail_penempatans.kode_barcode', '=', $keranjang->kode_barcode)
                ->first();
            $mutasi = DB::table('detail_mutasis')
                ->join('mutasis', 'mutasis.no_mutasi', '=', 'detail_mutasis.no_mutasi')
                ->where('detail_mutasis.kode_barcode', '=', $keranjang->kode_barcode)
                ->first();
            $lokasidetailbarang = DB::table('penempatans')
                ->join('detail_penempatans', 'penempatans.no_penempatan', '=', 'detail_penempatans.no_penempatan')
                ->where('detail_penempatans.kode_barcode', '=', $keranjang->kode_barcode)
                ->first();

            if ($mutasi == null) {
                $lokasi = DB::table('penempatans')
                ->join(
                    'detail_penempatans',
                    'penempatans.no_penempatan',
                    '=',
                    'detail_penempatans.no_penempatan',
                )->join(
                    'ruangans',
                    'penempatans.no_ruangan',
                    '=',
                    'ruangans.no_ruangan',
                )
                ->where('penempatans.no_penempatan', '=', $penempatan->no_penempatan)
                ->first();

            // dd($request->no_ruangan);

                if ($lokasi->no_ruangan == $request->no_ruangan) {
                    $request->session()->flash('error', 'Data gagal ditambahkan! Salah satu barang memiliki lokasi lama yang sama dengan lokasi baru');

                    return redirect('/mutasi-tambah');
                }
            } else {
                $lokasi = DB::table('penempatans')
                ->join(
                    'detail_penempatans',
                    'penempatans.no_penempatan',
                    '=',
                    'detail_penempatans.no_penempatan',
                )->join(
                    'ruangans',
                    'penempatans.no_ruangan',
                    '=',
                    'ruangans.no_ruangan',
                )
                ->where('penempatans.no_penempatan', '=', $penempatan->no_penempatan)
                ->first();
            $lokasibaru = DB::table('mutasis')
                ->join(
                    'detail_mutasis',
                    'mutasis.no_mutasi',
                    '=',
                    'detail_mutasis.no_mutasi',
                )->join(
                    'ruangans',
                    'mutasis.no_ruangan',
                    '=',
                    'ruangans.no_ruangan',
                )
                ->where('mutasis.no_mutasi', '=', $mutasi->no_mutasi)
                ->first();

                if ($lokasibaru->no_ruangan == $request->no_ruangan) {
                            // $request->session()->flash('error', 'Data gagal ditambahkan! Salah satu barang memiliki lokasi lama yang sama dengan lokasi baru');
            
                            // return redirect('/mutasi-tambah');
                            if ($lokasi->no_ruangan == $request->no_ruangan) {
                                $request->session()->flash('error', 'Data GAGAL ditambahkan! Salah satu barang memiliki lokasi lama yang sama dengan lokasi baru');
            
                                return redirect('/mutasi-tambah');
                            }
                        }
                    }

        //     // dd($mutasi);

        //     $lokasi = DB::table('penempatans')
        //         ->join(
        //             'detail_penempatans',
        //             'penempatans.no_penempatan',
        //             '=',
        //             'detail_penempatans.no_penempatan',
        //         )->join(
        //             'ruangans',
        //             'penempatans.no_ruangan',
        //             '=',
        //             'ruangans.no_ruangan',
        //         )
        //         ->where('penempatans.no_penempatan', '=', $penempatan->no_penempatan)
        //         ->first();

            //         return redirect('/mutasi-tambah');
            //     }
            // }
            // }

            
        }
        //     $lokasibaru = DB::table('mutasis')
        //         ->join(
        //             'detail_mutasis',
        //             'mutasis.no_mutasi',
        //             '=',
        //             'detail_mutasis.no_mutasi',
        //         )->join(
        //             'ruangans',
        //             'mutasis.no_ruangan',
        //             '=',
        //             'ruangans.no_ruangan',
        //         )
        //         ->where('mutasis.no_mutasi', '=',
        //          $mutasi->no_mutasi)
        //         ->first();

        //     // dd($request->no_ruangan);
        //     if ($lokasibaru->no_ruangan == $request->no_ruangan) {
        //         // $request->session()->flash('error', 'Data gagal ditambahkan! Salah satu barang memiliki lokasi lama yang sama dengan lokasi baru');

        //         // return redirect('/mutasi-tambah');
        //         if ($lokasi->no_ruangan == $request->no_ruangan) {
        //             $request->session()->flash('error', 'Data GAGAL ditambahkan! Salah satu barang memiliki lokasi lama yang sama dengan lokasi baru');

        //             return redirect('/mutasi-tambah');
        //         }
        //     }
        // }



        $validatedData = $request->validate([
            'no_mutasi' => '',
            'no_ruangan' => '',
            'keterangan' => 'nullable',
        ]);

        if ($request->keterangan == null) {

            $validatedData['keterangan'] = 'Mutasi baru.';

        }

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
            ->select('no_barang', 'status')
            ->where('kode_barcode', '=', $request->input('kode_barcode'))
            ->first();

        // dd($no_barang);

        $validatedData['no_barang'] = $no_barang->no_barang;

        if ($no_barang->status == 'Sudah Dihapus') {
            $request->session()->flash('error', 'Barang tersebut sudah masuk dalam Daftar Penghapusan!');

            return redirect('/peminjaman-tambah');

        }

        DB::table('keranjang_peminjamans')->insert($validatedData);

        $request->session()->flash('success', 'Barang masuk kedalam List Peminjaman!');

        return redirect('/peminjaman-tambah');
    }

    public function deleteKeranjangPeminjaman(Request $request)
    {

        $nama_barang = DB::table('keranjang_peminjamans')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'keranjang_peminjamans.kode_barcode')
            ->where('keranjang_peminjamans.no_peminjaman', '=', $request->input('no_peminjaman'))
            ->first();

        DB::table('keranjang_peminjamans')
            ->where('no_peminjaman', $request->input('no_peminjaman'))->delete();

        $pesanFlash = "Barang (Merk: *{$nama_barang->merk} ) telah berhasil dihapus dari list!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/peminjaman-tambah');
    }

    public function addPeminjaman(Request $request)
    {

        // dd($request);
        $validatedData = $request->validate([
            'no_peminjaman' => 'required',
            'tanggal_peminjaman' => '',
            'tanggal_kembali' => 'required',
            'id_pegawai' => 'requir ed',
            'status_peminjaman' => '',
            'keterangan' => 'nullable',
        ]);

        $nama_peminjam = DB::table('pegawais')
            ->where('nik', '=', $request->id_pegawai)
            ->select('nama_user')
            ->first();

        $nama = $nama_peminjam->nama_user;

        if ($request->keterangan == null) {
            $validatedData['keterangan'] = 'Pegawai(' . $nama . ') melakukan Peminjaman.';
        }

        // $validatedData['tanggal_penempatan'] = now()->format('Y-m-d');

        $kode_barcodes = DB::table('keranjang_peminjamans')->select('kode_barcode')->get();
        $validatedData['status_peminjaman'] = 'Dipinjam';

        // dd($validatedData);
        DB::table('peminjamans')->insert($validatedData);

        $validatedDataStatus['status_pinjam'] = "Dipinjam oleh: $nama";
        // dd($validatedDataStatus['status']);
        foreach ($kode_barcodes as $kode_barcode) {
            // return redirect('/jkbkhbd');
            DB::table('detail_barangs')
                ->where('kode_barcode', $kode_barcode->kode_barcode)
                ->update($validatedDataStatus);
        }


        DB::statement("INSERT INTO detail_peminjamans (no_peminjaman, no_barang, kode_barcode)
         SELECT '$request->no_peminjaman', no_barang, kode_barcode FROM keranjang_peminjamans");

        DB::table('keranjang_peminjamans')->truncate();


        $request->session()->flash('success', 'Peminjamaan telah berhasil Dilakukan!');

        return redirect('/peminjaman');

    }

    public function giveBackPeminjaman(Request $request, ruangan $ruangan)
    {
        // $validatedData['tanggal_selesai'] = now()->format('Y-m-d');
        $validatedData['status_peminjaman'] = "Dikembalikan";


        DB::table('peminjamans')
            ->where('no_peminjaman', $request->input('no_peminjaman'))
            ->update($validatedData);


        $request->session()->flash('success', 'Peminjaman telah selesai Dikembalikan!');

        return redirect('/peminjaman');
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
        $cek1 = DB::table('maintenances')->where('kode_barcode', '=', $request->kode_barcode)->first();
        $cek2 = DB::table('detail_penempatans')->where('kode_barcode', '=', $request->kode_barcode)->first();


        if ($cek1 == null) {
            $validatedData = $request->validate([
                'no_maintenance' => '',
                'biaya' => 'required|numeric',
                'keterangan' => 'nullable',
                'kode_barcode' => 'required',
            ]);

            if ($request->keterangan == null) {

                $validatedData['keterangan'] = 'Maintenance baru untuk pemeliharaan.';

            }

            $no_barang = DB::table('detail_barangs')->select('no_barang')->where('kode_barcode', '=', $request->kode_barcode)->first();

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
        } else if ($cek1->status == "Sedang Diproses") {

            $request->session()->flash('error', 'Barang sedang proses maintenance!');

            return redirect('/maintenance');
        }

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
        $cek1 = DB::table('keranjang_penghapusans')->where('kode_barcode', '=', $request->kode_barcode)->first();
        $cek2 = DB::table('detail_penghapusans')->where('kode_barcode', '=', $request->kode_barcode)->first();

        if ($cek1 == null) {
            if ($cek2 == null) {
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
            } else {
                $request->session()->flash('error', 'Barang sudah dihapus!');

                return redirect('/penghapusan-tambah');
            }
        } else {
            $request->session()->flash('error', 'Barang sudah ada di List Penghapusan!');

            return redirect('/penghapusan-tambah');
        }


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
            'keterangan' => 'nullable',
        ]);

        if ($request->keterangan == null) {

            $validatedData['keterangan'] = 'Penghapusan permanen karena: ' . $request->jenis_penghapusan . '.';

        }

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

