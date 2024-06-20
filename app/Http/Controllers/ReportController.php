<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\pegawai;
use App\Models\kategori_barang;
use App\Models\ruangan;
use App\Models\tipe_ruangan;
use App\Models\barang;
use App\Models\image_ruangan;
use App\Models\training;
use App\Models\departemen;
use App\Models\detail_barang;
use App\Models\peserta_training;
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
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    //PETUGAS
    public function goLaporanPetugas()
    {

        return view('petugas.layout.laporan.laporan-petugas')->with([
            'title' => 'Laporan Data Petugas',
            'active' => 'Laporan Data Petugas',
            'open' => 'yes-3',
            'petugass' => User::all(),
            'requests' => null

        ]);
    }
    public function goLaporanPetugasFilter(Request $request)
    {
        // Jika $dates tidak ada atau kosong, tetapkan nilai default sebagai string kosong
        // $filter = urldecode($filter ?? '');

        $date = $request->query('date');
        $role = $request->query('role');


        if ($role == "koordinator" || $role == "super_user") {
            if ($role == "koordinator") {
                $petugas = DB::table('users')->where('role', 'petugas')->get();
            } else {
                $petugas = DB::table('users')->where('role', $role)->get();
            }
        } else {
            $dateArray = explode('~', $date);

            $tanggalPertama = $dateArray[0] ?? null;
            $tanggalKedua = $dateArray[1] ?? null;

            if ($role == "koordinator") {
                $role = "petugas";
            }

            // dd($dateArray);

            // // Validasi bahwa kedua tanggal ada
            // if ($tanggalPertama && $tanggalKedua) {
            //     // Query dengan whereBetween
            //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
            // } elseif ($tanggalPertama) {
            //     // Query jika hanya tanggal pertama yang ada
            //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
            // } elseif ($tanggalKedua) {
            //     // Query jika hanya tanggal kedua yang ada
            //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
            // } else {
            //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
            //     $petugas = User::all();
            // }

            $query = User::query();

            if ($tanggalPertama && $tanggalKedua && $role) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role);
            } else if ($tanggalPertama && $tanggalKedua) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
            } elseif ($tanggalPertama && $role) {
                $query->where('created_at', '>=', $tanggalPertama)->where('role', $role);
            } elseif ($tanggalPertama) {
                $query->where('created_at', '>=', $tanggalPertama);
            } elseif ($tanggalKedua && $role) {
                $query->where('created_at', '<=', $tanggalKedua)->where('role', $role);
            } elseif ($tanggalKedua) {
                $query->where('created_at', '<=', $tanggalKedua);
            }
            // dd($query);

            // if ($role) {
            //     $query->where('role', $role);
            //     dd($query);
            // }

            $petugas = $query->get();

            // $petugas = DB::table('users')
            // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
            // ->get();
        }


        return view('petugas.layout.laporan.laporan-petugas')->with([
            'title' => 'Laporan Data Petugas',
            'active' => 'Laporan Data Petugas',
            'open' => 'yes-3',
            'petugass' => $petugas,
            'requests' => $request

        ]);
    }
    public function goLaporanPetugasPdf(Request $request)
    {
        if ($request->input('date') == null && $request->input('role') == null) {
            $data = [
                'petugass' => User::all(),
            ];
        } else {

            $date = $request->input('date');
            $role = $request->input('role');


            if ($role == "koordinator" || $role == "super_user") {
                if ($role == "koordinator") {
                    $petugas = DB::table('users')->where('role', 'petugas')->get();
                } else {
                    $petugas = DB::table('users')->where('role', $role)->get();
                }
            } else {
                $dateArray = explode('~', $date);

                $tanggalPertama = $dateArray[0] ?? null;
                $tanggalKedua = $dateArray[1] ?? null;

                if ($role == "koordinator") {
                    $role = "petugas";
                }

                // dd($dateArray);

                // // Validasi bahwa kedua tanggal ada
                // if ($tanggalPertama && $tanggalKedua) {
                //     // Query dengan whereBetween
                //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
                // } elseif ($tanggalPertama) {
                //     // Query jika hanya tanggal pertama yang ada
                //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
                // } elseif ($tanggalKedua) {
                //     // Query jika hanya tanggal kedua yang ada
                //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
                // } else {
                //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
                //     $petugas = User::all();
                // }

                $query = User::query();

                if ($tanggalPertama && $tanggalKedua && $role) {
                    $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role);
                } else if ($tanggalPertama && $tanggalKedua) {
                    $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                } elseif ($tanggalPertama && $role) {
                    $query->where('created_at', '>=', $tanggalPertama)->where('role', $role);
                } elseif ($tanggalPertama) {
                    $query->where('created_at', '>=', $tanggalPertama);
                } elseif ($tanggalKedua && $role) {
                    $query->where('created_at', '<=', $tanggalKedua)->where('role', $role);
                } elseif ($tanggalKedua) {
                    $query->where('created_at', '<=', $tanggalKedua);
                }
                // dd($query);

                // if ($role) {
                //     $query->where('role', $role);
                //     dd($query);
                // }

                $petugas = $query->get();

                // $petugas = DB::table('users')
                // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
                // ->get();
            }

            // $data = [$petugas];
            $data = [
                'petugass' => $petugas,
            ];
        }
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-petugas-pdf', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('invoice.pdf');
        return $pdf->stream('laporan-data-petugas.pdf');
    }
    //END PETUGAS

    //PEGAWAI
    public function goLaporanPegawai()
    {

        return view('petugas.layout.laporan.laporan-pegawai')->with([
            'title' => 'Laporan Data Pegawai',
            'active' => 'Laporan Data Pegawai',
            'open' => 'yes-3',
            'pegawais' => pegawai::all(),
            'requests' => null

        ]);
    }
    public function goLaporanPegawaiFilter(Request $request)
    {
        // Jika $dates tidak ada atau kosong, tetapkan nilai default sebagai string kosong
        // $filter = urldecode($filter ?? '');

        $date = $request->query('date');
        $departemen = $request->query('organisasi');
        $id_organisasi = DB::table('departemens')->where('no_departemen', $departemen)->first();


        if ($departemen) {
            $pegawai = DB::table('pegawais')->where('id_departemen', $id_organisasi->id)->get();
        } else {
            $dateArray = explode('~', $date);

            $tanggalPertama = $dateArray[0] ?? null;
            $tanggalKedua = $dateArray[1] ?? null;

            // dd($dateArray);

            // // Validasi bahwa kedua tanggal ada
            // if ($tanggalPertama && $tanggalKedua) {
            //     // Query dengan whereBetween
            //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
            // } elseif ($tanggalPertama) {
            //     // Query jika hanya tanggal pertama yang ada
            //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
            // } elseif ($tanggalKedua) {
            //     // Query jika hanya tanggal kedua yang ada
            //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
            // } else {
            //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
            //     $petugas = User::all();
            // }

            $query = pegawai::query();

            if ($tanggalPertama && $tanggalKedua && $departemen) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('id_departemen', $id_organisasi->id);
            } else if ($tanggalPertama && $tanggalKedua) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
            } elseif ($tanggalPertama && $departemen) {
                $query->where('created_at', '>=', $tanggalPertama)->where('id_departemen', $id_organisasi->id);
            } elseif ($tanggalPertama) {
                $query->where('created_at', '>=', $tanggalPertama);
            } elseif ($tanggalKedua && $departemen) {
                $query->where('created_at', '<=', $tanggalKedua)->where('id_departemen', $id_organisasi->id);
            } elseif ($tanggalKedua) {
                $query->where('created_at', '<=', $tanggalKedua);
            }
            // dd($query);

            // if ($role) {
            //     $query->where('role', $role);
            //     dd($query);
            // }

            $pegawai = $query->get();

            // $petugas = DB::table('users')
            // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
            // ->get();
        }


        return view('petugas.layout.laporan.laporan-pegawai')->with([
            'title' => 'Laporan Data Pegawai',
            'active' => 'Laporan Data Pegawai',
            'open' => 'yes-3',
            'pegawais' => $pegawai,
            'requests' => $request

        ]);
    }
    public function goLaporanPegawaiPdf(Request $request)
    {
        if ($request->input('date') == null && $request->input('organisasi') == null) {
            $data = [
                'pegawais' => pegawai::all(),
            ];
        } else {

            $date = $request->input('date');
            $organisasi = $request->input('organisasi');
            $id_organisasi = DB::table('departemens')->where('no_departemen', $organisasi)->first();

            if ($organisasi) {
                $pegawai = DB::table('pegawais')->where('id_departemen', $id_organisasi->id)->get();
            } else {
                $dateArray = explode('~', $date);

                $tanggalPertama = $dateArray[0] ?? null;
                $tanggalKedua = $dateArray[1] ?? null;


                // dd($dateArray);

                // // Validasi bahwa kedua tanggal ada
                // if ($tanggalPertama && $tanggalKedua) {
                //     // Query dengan whereBetween
                //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
                // } elseif ($tanggalPertama) {
                //     // Query jika hanya tanggal pertama yang ada
                //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
                // } elseif ($tanggalKedua) {
                //     // Query jika hanya tanggal kedua yang ada
                //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
                // } else {
                //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
                //     $petugas = User::all();
                // }

                $query = pegawai::query();

                if ($tanggalPertama && $tanggalKedua && $organisasi) {
                    $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('id_departemen', $id_organisasi->id);
                } else if ($tanggalPertama && $tanggalKedua) {
                    $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                } elseif ($tanggalPertama && $organisasi) {
                    $query->where('created_at', '>=', $tanggalPertama)->where('id_departemen', $id_organisasi->id);
                } elseif ($tanggalPertama) {
                    $query->where('created_at', '>=', $tanggalPertama);
                } elseif ($tanggalKedua && $organisasi) {
                    $query->where('created_at', '<=', $tanggalKedua)->where('id_departemen', $id_organisasi->id);
                } elseif ($tanggalKedua) {
                    $query->where('created_at', '<=', $tanggalKedua);
                }
                // dd($query);

                // if ($role) {
                //     $query->where('role', $role);
                //     dd($query);
                // }

                $pegawai = $query->get();

                // $petugas = DB::table('users')
                // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
                // ->get();
            }


            // $data = [$petugas];
            $data = [
                // 'pegawais' => $petugas,
                'pegawais' => $pegawai
            ];
            // }
            $pdf = Pdf::loadView('petugas.layout.laporan.laporan-pegawai-pdf', $data)->setPaper('a4', 'portrait');
            // return $pdf->download('invoice.pdf');
            return $pdf->stream('laporan-data-pegawai.pdf');
        }
    }
    //END PEGAWAI


    //BARANG
    public function goLaporanBarang()
    {
        $cekKategori = DB::table('kategori_barangs')->count();

        $kategoris = kategori_barang::all();

        $kategori_barang = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();

        return view('petugas.layout.laporan.laporan-barang')->with([
            'title' => 'Laporan Data Barang',
            'active' => 'Laporan Data Barang',
            'cek' => $cekKategori,
            'open' => 'yes-3',
            'barangs' => $kategori_barang,
            'kategoris' => $kategoris,
            'requests' => null

        ]);
    }
    public function goLaporanBarangFilter(Request $request)
    {
        // Jika $dates tidak ada atau kosong, tetapkan nilai default sebagai string kosong
        // $filter = urldecode($filter ?? '');

        $date = $request->query('date');
        $kategori = $request->query('kategori');


        if ($kategori) {
            $barang = DB::table('barangs')->where('id_kategori', $kategori)->get();
        } else {
            $dateArray = explode('~', $date);

            $tanggalPertama = $dateArray[0] ?? null;
            $tanggalKedua = $dateArray[1] ?? null;

            // dd($dateArray);

            // // Validasi bahwa kedua tanggal ada
            // if ($tanggalPertama && $tanggalKedua) {
            //     // Query dengan whereBetween
            //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
            // } elseif ($tanggalPertama) {
            //     // Query jika hanya tanggal pertama yang ada
            //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
            // } elseif ($tanggalKedua) {
            //     // Query jika hanya tanggal kedua yang ada
            //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
            // } else {
            //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
            //     $petugas = User::all();
            // }

            $query = barang::query();

            if ($tanggalPertama && $tanggalKedua && $kategori) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('id_kategori', $kategori);
            } else if ($tanggalPertama && $tanggalKedua) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
            } elseif ($tanggalPertama && $kategori) {
                $query->where('created_at', '>=', $tanggalPertama)->where('id_kategori', $kategori);
            } elseif ($tanggalPertama) {
                $query->where('created_at', '>=', $tanggalPertama);
            } elseif ($tanggalKedua && $kategori) {
                $query->where('created_at', '<=', $tanggalKedua)->where('id_kategori', $kategori);
            } elseif ($tanggalKedua) {
                $query->where('created_at', '<=', $tanggalKedua);
            }
            // dd($query);

            // if ($role) {
            //     $query->where('role', $role);
            //     dd($query);
            // }

            $barang = $query->get();

            // $petugas = DB::table('users')
            // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
            // ->get();
        }


        return view('petugas.layout.laporan.laporan-barang')->with([
            'title' => 'Laporan Data Barang',
            'active' => 'Laporan Data Barang',
            'open' => 'yes-3',
            'barangs' => $barang,
            'requests' => $request

        ]);
    }
    public function goLaporanBarangPdf(Request $request)
    {
        if ($request->input('date') == null && $request->input('kategori') == null) {
            $barang = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                ->select('barangs.*', 'kategori_barangs.nama_kategori')
                ->get();
            $data = [
                'barangs' => $barang,
            ];
        } else {

            $date = $request->input('date');
            $kategori = $request->input('kategori');


            if ($kategori) {
                $barang = DB::table('barangs')->where('id_kategori', $kategori)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                    ->select('barangs.*', 'kategori_barangs.nama_kategori')->get();
            } else {
                $dateArray = explode('~', $date);

                $tanggalPertama = $dateArray[0] ?? null;
                $tanggalKedua = $dateArray[1] ?? null;

                // dd($dateArray);

                // // Validasi bahwa kedua tanggal ada
                // if ($tanggalPertama && $tanggalKedua) {
                //     // Query dengan whereBetween
                //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
                // } elseif ($tanggalPertama) {
                //     // Query jika hanya tanggal pertama yang ada
                //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
                // } elseif ($tanggalKedua) {
                //     // Query jika hanya tanggal kedua yang ada
                //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
                // } else {
                //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
                //     $petugas = User::all();
                // }

                $query = barang::query();

                if ($tanggalPertama && $tanggalKedua && $kategori) {
                    $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('id_kategori', $kategori)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                } else if ($tanggalPertama && $tanggalKedua) {
                    $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                } elseif ($tanggalPertama && $kategori) {
                    $query->where('created_at', '>=', $tanggalPertama)->where('id_kategori', $kategori)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                } elseif ($tanggalPertama) {
                    $query->where('created_at', '>=', $tanggalPertama)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                } elseif ($tanggalKedua && $kategori) {
                    $query->where('created_at', '<=', $tanggalKedua)->where('id_kategori', $kategori)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                } elseif ($tanggalKedua) {
                    $query->where('created_at', '<=', $tanggalKedua)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                }
                // dd($query);

                // if ($role) {
                //     $query->where('role', $role);
                //     dd($query);
                // }

                $barang = $query->get();

                // $petugas = DB::table('users')
                // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
                // ->get();
            }

            // $data = [$petugas];

            $cekKategori = DB::table('kategori_barangs')->count();

            // $barangs = barang::all();

            $kategori_barang = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                ->select('barangs.*', 'kategori_barangs.nama_kategori')
                ->get();
            $data = [
                // 'pegawais' => $petugas,
                // 'assets' => $kategori_barang,
                'barangs' => $kategori_barang
            ];
            // }
        }
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-barang-pdf', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('invoice.pdf');
        return $pdf->stream('laporan-data-barang.pdf');
    }
    //END BARANG

    //RUANGAN
    public function goLaporanRuangan()
    {
        $cekTipe = DB::table('tipe_ruangans')->count();

        return view('petugas.layout.laporan.laporan-ruangan')->with([
            'title' => 'Laporan Data Ruangan',
            'active' => 'Laporan Data Ruangan',
            'cek' => $cekTipe,
            'open' => 'yes-3',
            'ruangans' => ruangan::all(),
            'requests' => null

        ]);
    }
    public function goLaporanRuanganFilter(Request $request)
    {
        // Jika $dates tidak ada atau kosong, tetapkan nilai default sebagai string kosong
        // $filter = urldecode($filter ?? '');

        $date = $request->query('date');
        $tipe = $request->query('tipe');


        if ($tipe) {
            $ruangan = DB::table('ruangans')->where('tipe_ruangan', $tipe)->get();
        } else {
            $dateArray = explode('~', $date);

            $tanggalPertama = $dateArray[0] ?? null;
            $tanggalKedua = $dateArray[1] ?? null;

            // dd($dateArray);

            // // Validasi bahwa kedua tanggal ada
            // if ($tanggalPertama && $tanggalKedua) {
            //     // Query dengan whereBetween
            //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
            // } elseif ($tanggalPertama) {
            //     // Query jika hanya tanggal pertama yang ada
            //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
            // } elseif ($tanggalKedua) {
            //     // Query jika hanya tanggal kedua yang ada
            //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
            // } else {
            //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
            //     $petugas = User::all();
            // }

            $query = ruangan::query();

            if ($tanggalPertama && $tanggalKedua && $tipe) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('tipe_ruangan', $tipe);
            } else if ($tanggalPertama && $tanggalKedua) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
            } elseif ($tanggalPertama && $tipe) {
                $query->where('created_at', '>=', $tanggalPertama)->where('tipe_ruangan', $tipe);
            } elseif ($tanggalPertama) {
                $query->where('created_at', '>=', $tanggalPertama);
            } elseif ($tanggalKedua && $tipe) {
                $query->where('created_at', '<=', $tanggalKedua)->where('tipe_ruangan', $tipe);
            } elseif ($tanggalKedua) {
                $query->where('created_at', '<=', $tanggalKedua);
            }
            // dd($query);

            // if ($role) {
            //     $query->where('role', $role);
            //     dd($query);
            // }

            $ruangan = $query->get();

            // $petugas = DB::table('users')
            // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
            // ->get();
        }


        return view('petugas.layout.laporan.laporan-ruangan')->with([
            'title' => 'Laporan Data Ruangan',
            'active' => 'Laporan Data Ruangan',
            'open' => 'yes-3',
            'ruangans' => $ruangan,
            'requests' => $request

        ]);
    }
    public function goLaporanRuanganPdf(Request $request)
    {
        if ($request->getRequestUri() == "/print-data-ruangan-pdf?") {
            $ruangan = ruangan::join('tipe_ruangans', 'tipe_ruangans.id', '=', 'ruangans.tipe_ruangan')
                ->select('ruangans.*', 'tipe_ruangans.nama_tipe')
                ->get();
            $data = [
                // 'pegawais' => $petugas,
                // 'assets' => $kategori_barang,
                'ruangans' => $ruangan
            ];
            $pdf = Pdf::loadView('petugas.layout.laporan.laporan-ruangan-pdf', $data)->setPaper('a4', 'portrait');
            // return $pdf->download('invoice.pdf');
            return $pdf->stream('laporan-data-ruangan.pdf');
        } else {
            if ($request->query('no_ruangan')) {
                $ruangan = ruangan::join('tipe_ruangans', 'tipe_ruangans.id', '=', 'ruangans.tipe_ruangan')
                    ->select('ruangans.*', 'tipe_ruangans.nama_tipe')
                    ->where('no_ruangan', '=', $request->query('no_ruangan'))
                    ->get();
                $data = [
                    // 'pegawais' => $petugas,
                    // 'assets' => $kategori_barang,
                    'ruangans' => $ruangan
                ];
                // }
                $pdf = Pdf::loadView('petugas.layout.laporan.laporan-ruangan-pdf', $data)->setPaper('a4', 'portrait');
                // return $pdf->download('invoice.pdf');
                return $pdf->stream('laporan-data-ruangan.pdf');
            } else {
                if ($request->input('date') == null && $request->input('tipe') == null) {
                    $data = [
                        'ruangans' => ruangan::all(),
                    ];
                } else {

                    $date = $request->input('date');
                    $tipe = $request->input('tipe');


                    if ($tipe) {
                        $ruangan = DB::table('ruangans')->where('tipe_ruangan', $tipe)->get();
                    } else {
                        $dateArray = explode('~', $date);

                        $tanggalPertama = $dateArray[0] ?? null;
                        $tanggalKedua = $dateArray[1] ?? null;

                        // dd($dateArray);

                        // // Validasi bahwa kedua tanggal ada
                        // if ($tanggalPertama && $tanggalKedua) {
                        //     // Query dengan whereBetween
                        //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
                        // } elseif ($tanggalPertama) {
                        //     // Query jika hanya tanggal pertama yang ada
                        //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
                        // } elseif ($tanggalKedua) {
                        //     // Query jika hanya tanggal kedua yang ada
                        //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
                        // } else {
                        //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
                        //     $petugas = User::all();
                        // }

                        $query = ruangan::query();

                        if ($tanggalPertama && $tanggalKedua && $tipe) {
                            $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('tipe_ruangan', $tipe);
                        } else if ($tanggalPertama && $tanggalKedua) {
                            $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                        } elseif ($tanggalPertama && $tipe) {
                            $query->where('created_at', '>=', $tanggalPertama)->where('tipe_ruangan', $tipe);
                        } elseif ($tanggalPertama) {
                            $query->where('created_at', '>=', $tanggalPertama);
                        } elseif ($tanggalKedua && $tipe) {
                            $query->where('created_at', '<=', $tanggalKedua)->where('tipe_ruangan', $tipe);
                        } elseif ($tanggalKedua) {
                            $query->where('created_at', '<=', $tanggalKedua);
                        }
                        // dd($query);

                        // if ($role) {
                        //     $query->where('role', $role);
                        //     dd($query);
                        // }

                        $ruangan = $query->get();

                        // $petugas = DB::table('users')
                        // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
                        // ->get();
                    }
                    // dd($ruangan);

                    // $data = [$petugas];



                    $data = [
                        // 'pegawais' => $petugas,
                        // 'assets' => $kategori_barang,
                        'ruangans' => $ruangan
                    ];
                    // }
                    $pdf = Pdf::loadView('petugas.layout.laporan.laporan-ruangan-pdf', $data)->setPaper('a4', 'portrait');
                    // return $pdf->download('invoice.pdf');
                    return $pdf->stream('laporan-data-ruangan.pdf');
                }
            }
        }



    }
    //END RUANGAN

    //DEPARTEMEN
    public function goLaporanDepartemen()
    {
        return view('petugas.layout.laporan.laporan-departemen')->with([
            'title' => 'Laporan Data Departemen',
            'active' => 'Laporan Data Departemen',
            'open' => 'yes-3',
            'departemens' => departemen::all(),
            'requests' => null

        ]);
    }
    public function goLaporanDepartemenFilter(Request $request)
    {
        // Jika $dates tidak ada atau kosong, tetapkan nilai default sebagai string kosong
        // $filter = urldecode($filter ?? '');

        $date = $request->query('date');



        $dateArray = explode('~', $date);

        $tanggalPertama = $dateArray[0] ?? null;
        $tanggalKedua = $dateArray[1] ?? null;

        // dd($dateArray);

        // // Validasi bahwa kedua tanggal ada
        // if ($tanggalPertama && $tanggalKedua) {
        //     // Query dengan whereBetween
        //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        // } elseif ($tanggalPertama) {
        //     // Query jika hanya tanggal pertama yang ada
        //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        // } elseif ($tanggalKedua) {
        //     // Query jika hanya tanggal kedua yang ada
        //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        // } else {
        //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //     $petugas = User::all();
        // }

        $query = departemen::query();

        if ($tanggalPertama && $tanggalKedua) {
            $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        } elseif ($tanggalPertama) {
            $query->where('created_at', '>=', $tanggalPertama);
        } elseif ($tanggalKedua) {
            $query->where('created_at', '<=', $tanggalKedua);
        }
        // dd($query);

        // if ($role) {
        //     $query->where('role', $role);
        //     dd($query);
        // }

        $departemen = $query->get();

        // $petugas = DB::table('users')
        // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        // ->get();


        return view('petugas.layout.laporan.laporan-departemen')->with([
            'title' => 'Laporan Data Departemen',
            'active' => 'Laporan Data Departemen',
            'open' => 'yes-3',
            'departemens' => $departemen,
            'requests' => $request

        ]);
    }
    public function goLaporanDepartemenPdf(Request $request)
    {
        if ($request->getRequestUri() == "/print-data-departemen-pdf?") {
            $data = [
                // 'pegawais' => $petugas,
                // 'assets' => $kategori_barang,
                'departemens' => departemen::all()
            ];
            $pdf = Pdf::loadView('petugas.layout.laporan.laporan-departemen-pdf', $data)->setPaper('a4', 'portrait');
            // return $pdf->download('invoice.pdf');
            return $pdf->stream('laporan-data-departemen.pdf');
        } else {
            if ($request->input('date') == null) {
                $data = [
                    'departemens' => departemen::all(),
                ];
            } else {

                $date = $request->input('date');

                $dateArray = explode('~', $date);

                $tanggalPertama = $dateArray[0] ?? null;
                $tanggalKedua = $dateArray[1] ?? null;

                // dd($dateArray);

                // // Validasi bahwa kedua tanggal ada
                // if ($tanggalPertama && $tanggalKedua) {
                //     // Query dengan whereBetween
                //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
                // } elseif ($tanggalPertama) {
                //     // Query jika hanya tanggal pertama yang ada
                //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
                // } elseif ($tanggalKedua) {
                //     // Query jika hanya tanggal kedua yang ada
                //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
                // } else {
                //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
                //     $petugas = User::all();
                // }

                $query = departemen::query();

                if ($tanggalPertama && $tanggalKedua) {
                    $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                } elseif ($tanggalPertama) {
                    $query->where('created_at', '>=', $tanggalPertama);
                } elseif ($tanggalKedua) {
                    $query->where('created_at', '<=', $tanggalKedua);
                }
                // dd($query);

                // if ($role) {
                //     $query->where('role', $role);
                //     dd($query);
                // }

                $departemen = $query->get();

                // $petugas = DB::table('users')
                // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
                // ->get();
                // dd($ruangan);

                // $data = [$petugas];



                $data = [
                    // 'pegawais' => $petugas,
                    // 'assets' => $kategori_barang,
                    'departemens' => $departemen
                ];
                // }
            }
            $pdf = Pdf::loadView('petugas.layout.laporan.laporan-departemen-pdf', $data)->setPaper('a4', 'portrait');
            // return $pdf->download('invoice.pdf');
            return $pdf->stream('laporan-data-departemen.pdf');
        }



    }
    //END DEPARTEMEN

    //PENGADAAN
    public function goLaporanPengadaan()
    {
        $cekTipe = DB::table('tipe_ruangans')->count();

        return view('petugas.layout.laporan.laporan-pengadaan')->with([
            'title' => 'Laporan Data Pengadaan',
            'active' => 'Laporan Data Pengadaan',
            'cek' => $cekTipe,
            'open' => 'yes-3',
            'pengadaans' => pengadaan::all(),
            'requests' => null

        ]);
    }
    public function goLaporanPengadaanFilter(Request $request)
    {
        // Jika $dates tidak ada atau kosong, tetapkan nilai default sebagai string kosong
        // $filter = urldecode($filter ?? '');

        $date = $request->query('date');



        $dateArray = explode('~', $date);

        $tanggalPertama = $dateArray[0] ?? null;
        $tanggalKedua = $dateArray[1] ?? null;

        // dd($dateArray);

        // // Validasi bahwa kedua tanggal ada
        // if ($tanggalPertama && $tanggalKedua) {
        //     // Query dengan whereBetween
        //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        // } elseif ($tanggalPertama) {
        //     // Query jika hanya tanggal pertama yang ada
        //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        // } elseif ($tanggalKedua) {
        //     // Query jika hanya tanggal kedua yang ada
        //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        // } else {
        //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //     $petugas = User::all();
        // }

        $query = pengadaan::query();

        if ($tanggalPertama && $tanggalKedua) {
            $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        } elseif ($tanggalPertama) {
            $query->where('created_at', '>=', $tanggalPertama);
        } elseif ($tanggalKedua) {
            $query->where('created_at', '<=', $tanggalKedua);
        }
        // dd($query);

        // if ($role) {
        //     $query->where('role', $role);
        //     dd($query);
        // }

        $pengadaan = $query->get();

        // $petugas = DB::table('users')
        // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        // ->get();


        return view('petugas.layout.laporan.laporan-pengadaan')->with([
            'title' => 'Laporan Data Pengadaan',
            'active' => 'Laporan Data Pengadaan',
            'open' => 'yes-3',
            'pengadaans' => $pengadaan,
            'requests' => $request

        ]);
    }
    public function goLaporanPengadaanPdf(Request $request)
    {
        if ($request->getRequestUri() == "/print-data-pengadaan-pdf?") {
            $data = [
                // 'pegawais' => $petugas,
                // 'assets' => $kategori_barang,
                'pengadaans' => pengadaan::all()
            ];
            $pdf = Pdf::loadView('petugas.layout.laporan.laporan-pengadaan-pdf', $data)->setPaper('a4', 'portrait');
            // return $pdf->download('invoice.pdf');
            return $pdf->stream('laporan-data-pengadaan.pdf');
        } else {
            if ($request->input('date') == null) {
                $data = [
                    'pengadaans' => pengadaan::all(),
                ];
            } else {

                $date = $request->input('date');

                $dateArray = explode('~', $date);

                $tanggalPertama = $dateArray[0] ?? null;
                $tanggalKedua = $dateArray[1] ?? null;

                // dd($dateArray);

                // // Validasi bahwa kedua tanggal ada
                // if ($tanggalPertama && $tanggalKedua) {
                //     // Query dengan whereBetween
                //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
                // } elseif ($tanggalPertama) {
                //     // Query jika hanya tanggal pertama yang ada
                //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
                // } elseif ($tanggalKedua) {
                //     // Query jika hanya tanggal kedua yang ada
                //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
                // } else {
                //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
                //     $petugas = User::all();
                // }

                $query = pengadaan::query();

                if ($tanggalPertama && $tanggalKedua) {
                    $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                } elseif ($tanggalPertama) {
                    $query->where('created_at', '>=', $tanggalPertama);
                } elseif ($tanggalKedua) {
                    $query->where('created_at', '<=', $tanggalKedua);
                }
                // dd($query);

                // if ($role) {
                //     $query->where('role', $role);
                //     dd($query);
                // }

                $pengadaan = $query->get();

                // $petugas = DB::table('users')
                // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
                // ->get();
                // dd($ruangan);

                // $data = [$petugas];



                $data = [
                    // 'pegawais' => $petugas,
                    // 'assets' => $kategori_barang,
                    'pengadaans' => $pengadaan
                ];
                // }
            }
            $pdf = Pdf::loadView('petugas.layout.laporan.laporan-pengadaan-pdf', $data)->setPaper('a4', 'portrait');
            // return $pdf->download('invoice.pdf');
            return $pdf->stream('laporan-data-pengadaan.pdf');
        }
    }
    //END PENGADAAN

    //PENEMPATAN
    public function goLaporanPenempatan()
    {
        $data_penempatans = DB::table('penempatans')->select('*')->get();

        $penempatans = DB::table('penempatans')
            ->join('detail_penempatans', 'detail_penempatans.no_penempatan', '=', 'penempatans.no_penempatan')
            ->select('penempatans.*', 'detail_penempatans.kode_barcode')
            ->get();

        return view('petugas.layout.laporan.laporan-penempatan')->with([
            'title' => 'Laporan Data Penempatan',
            'active' => 'Laporan Data Penempatan',
            'open' => 'yes-3',
            'penempatans' => $penempatans,
            'data_penempatans' => $data_penempatans,
            'requests' => null

        ]);
    }
    public function goLaporanPenempatanFilter(Request $request)
    {
        // Jika $dates tidak ada atau kosong, tetapkan nilai default sebagai string kosong
        // $filter = urldecode($filter ?? '');
        $penempatans = DB::table('penempatans')
            ->join('detail_penempatans', 'detail_penempatans.no_penempatan', '=', 'penempatans.no_penempatan')
            ->select('penempatans.*', 'detail_penempatans.kode_barcode')
            ->get();

        $date = $request->query('date');



        $dateArray = explode('~', $date);

        $tanggalPertama = $dateArray[0] ?? null;
        $tanggalKedua = $dateArray[1] ?? null;

        // dd($dateArray);

        // // Validasi bahwa kedua tanggal ada
        // if ($tanggalPertama && $tanggalKedua) {
        //     // Query dengan whereBetween
        //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        // } elseif ($tanggalPertama) {
        //     // Query jika hanya tanggal pertama yang ada
        //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        // } elseif ($tanggalKedua) {
        //     // Query jika hanya tanggal kedua yang ada
        //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        // } else {
        //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //     $petugas = User::all();
        // }

        $query = penempatan::query();

        if ($tanggalPertama && $tanggalKedua) {
            $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        } elseif ($tanggalPertama) {
            $query->where('created_at', '>=', $tanggalPertama);
        } elseif ($tanggalKedua) {
            $query->where('created_at', '<=', $tanggalKedua);
        }
        // dd($query);

        // if ($role) {
        //     $query->where('role', $role);
        //     dd($query);
        // }

        $data_penempatan = $query->get();

        // $petugas = DB::table('users')
        // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        // ->get();


        return view('petugas.layout.laporan.laporan-penempatan')->with([
            'title' => 'Laporan Data Penempatan',
            'active' => 'Laporan Data Penempatan',
            'open' => 'yes-3',
            'penempatans' => $penempatans,
            'data_penempatans' => $data_penempatan,
            'requests' => $request

        ]);
    }
    public function goLaporanPenempatanPdf(Request $request)
    {
        if ($request->getRequestUri() == "/print-data-penempatan-pdf?") {
            $data = [
                // 'pegawais' => $petugas,
                // 'assets' => $kategori_barang,
                'penempatans' => penempatan::all()
            ];
            $pdf = Pdf::loadView('petugas.layout.laporan.laporan-penempatan-pdf', $data)->setPaper('a4', 'portrait');
            // return $pdf->download('invoice.pdf');
            return $pdf->stream('laporan-data-penempatan.pdf');
        } else {
            if ($request->query('no_penempatan')) {
                $penempatans = penempatan::select('*')
                    ->where('no_penempatan', '=', $request->query('no_penempatan'))
                    ->get();
                $data = [
                    // 'pegawais' => $petugas,
                    // 'assets' => $kategori_barang,
                    'penempatans' => $penempatans
                ];
                $pdf = Pdf::loadView('petugas.layout.laporan.laporan-penempatan-pdf', $data)->setPaper('a4', 'portrait');
                // return $pdf->download('invoice.pdf');
                return $pdf->stream('laporan-data-penempatan.pdf');
            } else {
                if ($request->input('date') == null) {
                    $data = [
                        'penempatans' => penempatan::all(),
                    ];
                } else {

                    $date = $request->input('date');

                    $dateArray = explode('~', $date);

                    $tanggalPertama = $dateArray[0] ?? null;
                    $tanggalKedua = $dateArray[1] ?? null;

                    // dd($dateArray);

                    // // Validasi bahwa kedua tanggal ada
                    // if ($tanggalPertama && $tanggalKedua) {
                    //     // Query dengan whereBetween
                    //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
                    // } elseif ($tanggalPertama) {
                    //     // Query jika hanya tanggal pertama yang ada
                    //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
                    // } elseif ($tanggalKedua) {
                    //     // Query jika hanya tanggal kedua yang ada
                    //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
                    // } else {
                    //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
                    //     $petugas = User::all();
                    // }

                    $query = penempatan::query();

                    if ($tanggalPertama && $tanggalKedua) {
                        $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                    } elseif ($tanggalPertama) {
                        $query->where('created_at', '>=', $tanggalPertama);
                    } elseif ($tanggalKedua) {
                        $query->where('created_at', '<=', $tanggalKedua);
                    }
                    // dd($query);

                    // if ($role) {
                    //     $query->where('role', $role);
                    //     dd($query);
                    // }

                    $penempatan = $query->get();

                    // $petugas = DB::table('users')
                    // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
                    // ->get();
                    // dd($ruangan);

                    // $data = [$petugas];



                    $data = [
                        // 'pegawais' => $petugas,
                        // 'assets' => $kategori_barang,
                        'penempatans' => $penempatan
                    ];
                    // }
                }
                $pdf = Pdf::loadView('petugas.layout.laporan.laporan-penempatan-pdf', $data)->setPaper('a4', 'portrait');
                // return $pdf->download('invoice.pdf');
                return $pdf->stream('laporan-data-penempatan.pdf');
            }

        }
    }
    //END PENEMPATAN

    //MUTASI
    public function goLaporanMutasi()
    {

        $mutasis = DB::table('mutasis')
            ->select('*')
            ->get();


        return view('petugas.layout.laporan.laporan-mutasi')->with([
            'title' => 'Laporan Data Mutasi',
            'active' => 'Laporan Data Mutasi',
            'open' => 'yes-3',
            'mutasis' => $mutasis,
            'requests' => null

        ]);
    }
    public function goLaporanMutasiFilter(Request $request)
    {
        // Jika $dates tidak ada atau kosong, tetapkan nilai default sebagai string kosong
        // $filter = urldecode($filter ?? '');

        $date = $request->query('date');



        $dateArray = explode('~', $date);

        $tanggalPertama = $dateArray[0] ?? null;
        $tanggalKedua = $dateArray[1] ?? null;

        // dd($dateArray);

        // // Validasi bahwa kedua tanggal ada
        // if ($tanggalPertama && $tanggalKedua) {
        //     // Query dengan whereBetween
        //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        // } elseif ($tanggalPertama) {
        //     // Query jika hanya tanggal pertama yang ada
        //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        // } elseif ($tanggalKedua) {
        //     // Query jika hanya tanggal kedua yang ada
        //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        // } else {
        //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //     $petugas = User::all();
        // }

        $query = mutasi::query();

        if ($tanggalPertama && $tanggalKedua) {
            $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        } elseif ($tanggalPertama) {
            $query->where('created_at', '>=', $tanggalPertama);
        } elseif ($tanggalKedua) {
            $query->where('created_at', '<=', $tanggalKedua);
        }
        // dd($query);

        // if ($role) {
        //     $query->where('role', $role);
        //     dd($query);
        // }

        $mutasi = $query->get();

        // $petugas = DB::table('users')
        // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        // ->get();


        return view('petugas.layout.laporan.laporan-mutasi')->with([
            'title' => 'Laporan Data Mutasi',
            'active' => 'Laporan Data Mutasi',
            'open' => 'yes-3',
            'mutasis' => $mutasi,
            'requests' => $request

        ]);

    }
    public function goLaporanMutasiPdf(Request $request)
    {
        if ($request->getRequestUri() == "/print-data-mutasi-pdf?") {
            $data = [
                // 'pegawais' => $petugas,
                // 'assets' => $kategori_barang,
                'mutasis' => mutasi::all()
            ];
            $pdf = Pdf::loadView('petugas.layout.laporan.laporan-mutasi-pdf', $data)->setPaper('a4', 'portrait');
            // return $pdf->download('invoice.pdf');
            return $pdf->stream('laporan-data-mutasi.pdf');
        } else {
            if ($request->query('no_mutasi')) {
                $mutasis = mutasi::select('*')
                    ->where('no_mutasi', '=', $request->query('no_mutasi'))
                    ->get();
                $data = [
                    // 'pegawais' => $petugas,
                    // 'assets' => $kategori_barang,
                    'mutasis' => $mutasis
                ];
                $pdf = Pdf::loadView('petugas.layout.laporan.laporan-mutasi-pdf', $data)->setPaper('a4', 'portrait');
                // return $pdf->download('invoice.pdf');
                return $pdf->stream('laporan-data-mutasi.pdf');
            } else {
                if ($request->input('date') == null) {
                    $data = [
                        'mutasis' => mutasi::all(),
                    ];
                } else {

                    $date = $request->input('date');

                    $dateArray = explode('~', $date);

                    $tanggalPertama = $dateArray[0] ?? null;
                    $tanggalKedua = $dateArray[1] ?? null;

                    // dd($dateArray);

                    // // Validasi bahwa kedua tanggal ada
                    // if ($tanggalPertama && $tanggalKedua) {
                    //     // Query dengan whereBetween
                    //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
                    // } elseif ($tanggalPertama) {
                    //     // Query jika hanya tanggal pertama yang ada
                    //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
                    // } elseif ($tanggalKedua) {
                    //     // Query jika hanya tanggal kedua yang ada
                    //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
                    // } else {
                    //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
                    //     $petugas = User::all();
                    // }

                    $query = mutasi::query();

                    if ($tanggalPertama && $tanggalKedua) {
                        $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                    } elseif ($tanggalPertama) {
                        $query->where('created_at', '>=', $tanggalPertama);
                    } elseif ($tanggalKedua) {
                        $query->where('created_at', '<=', $tanggalKedua);
                    }
                    // dd($query);

                    // if ($role) {
                    //     $query->where('role', $role);
                    //     dd($query);
                    // }

                    $mutasi = $query->get();

                    // $petugas = DB::table('users')
                    // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
                    // ->get();
                    // dd($ruangan);

                    // $data = [$petugas];



                    $data = [
                        // 'pegawais' => $petugas,
                        // 'assets' => $kategori_barang,
                        'mutasis' => $mutasi
                    ];
                    // }
                }
                $pdf = Pdf::loadView('petugas.layout.laporan.laporan-mutasi-pdf', $data)->setPaper('a4', 'portrait');
                // return $pdf->download('invoice.pdf');
                return $pdf->stream('laporan-data-mutasi.pdf');
            }

        }
    }
    //END MUTASI

    //PEMINJAMAN
    public function goLaporanPeminjaman()
    {

        $peminjamans = DB::table('peminjamans')
            ->select('*')
            ->get();


        return view('petugas.layout.laporan.laporan-peminjaman')->with([
            'title' => 'Laporan Data Peminjaman',
            'active' => 'Laporan Data Peminjaman',
            'open' => 'yes-3',
            'peminjamans' => $peminjamans,
            'requests' => null

        ]);

    }
    public function goLaporanPeminjamanFilter(Request $request)
    {
        // Jika $dates tidak ada atau kosong, tetapkan nilai default sebagai string kosong
        // $filter = urldecode($filter ?? '');

        $date = $request->query('date');



        $dateArray = explode('~', $date);

        $tanggalPertama = $dateArray[0] ?? null;
        $tanggalKedua = $dateArray[1] ?? null;

        // dd($dateArray);

        // // Validasi bahwa kedua tanggal ada
        // if ($tanggalPertama && $tanggalKedua) {
        //     // Query dengan whereBetween
        //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        // } elseif ($tanggalPertama) {
        //     // Query jika hanya tanggal pertama yang ada
        //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        // } elseif ($tanggalKedua) {
        //     // Query jika hanya tanggal kedua yang ada
        //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        // } else {
        //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //     $petugas = User::all();
        // }

        // $query = DB::table('peminjamans')->query();

        if ($tanggalPertama && $tanggalKedua) {
            $query = DB::table('peminjamans')->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        } elseif ($tanggalPertama) {
            $query = DB::table('peminjamans')->where('created_at', '>=', $tanggalPertama);
        } elseif ($tanggalKedua) {
            $query = DB::table('peminjamans')->where('created_at', '<=', $tanggalKedua);
        }
        // dd($query);

        // if ($role) {
        //     $query->where('role', $role);
        //     dd($query);
        // }

        $peminjaman = $query->get();

        // $petugas = DB::table('users')
        // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        // ->get();


        return view('petugas.layout.laporan.laporan-peminjaman')->with([
            'title' => 'Laporan Data Peminjaman',
            'active' => 'Laporan Data Peminjaman',
            'open' => 'yes-3',
            'peminjamans' => $peminjaman,
            'requests' => $request

        ]);
    }
    public function goLaporanPeminjamanPdf(Request $request)
    {
        if ($request->getRequestUri() == "/print-data-peminjaman-pdf?") {
            $peminjamans = DB::table('peminjamans')
                ->select('*')
                ->get();
            $kode_barcode = null;
            $data = [
                // 'pegawais' => $petugas,
                // 'assets' => $kategori_barang,
                'peminjamans' => $peminjamans,
                'kode_barcode' => $kode_barcode
            ];
            $pdf = Pdf::loadView('petugas.layout.laporan.laporan-peminjaman-pdf', $data)->setPaper('a4', 'portrait');
            // return $pdf->download('invoice.pdf');
            return $pdf->stream('laporan-data-peminjaman.pdf');
        } else {
            if ($request->query('no_peminjaman') || $request->query('kode_barcode')) {
                $peminjamans = DB::table('peminjamans')
                    ->select('*')
                    ->where('no_peminjaman', '=', $request->query('no_peminjaman'))
                    ->get();
                $kode_barcode = $request->query('kode_barcode');
                $data = [
                    // 'pegawais' => $petugas,
                    // 'assets' => $kategori_barang,
                    'peminjamans' => $peminjamans,
                    'kode_barcode' => $kode_barcode
                ];
                $pdf = Pdf::loadView('petugas.layout.laporan.laporan-peminjaman-pdf', $data)->setPaper('a4', 'portrait');
                // return $pdf->download('invoice.pdf');
                return $pdf->stream('laporan-data-peminjaman.pdf');
            } else {
                $kode_barcode = null;
                if ($request->input('date') == null) {
                    $peminjamans = DB::table('peminjamans')
                        ->select('*')
                        ->get();
                    $data = [
                        'peminjamans' => $peminjamans,
                        'kode_barcode' => $kode_barcode
                    ];
                } else {

                    $date = $request->input('date');

                    $dateArray = explode('~', $date);

                    $tanggalPertama = $dateArray[0] ?? null;
                    $tanggalKedua = $dateArray[1] ?? null;

                    // dd($dateArray);

                    // // Validasi bahwa kedua tanggal ada
                    // if ($tanggalPertama && $tanggalKedua) {
                    //     // Query dengan whereBetween
                    //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
                    // } elseif ($tanggalPertama) {
                    //     // Query jika hanya tanggal pertama yang ada
                    //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
                    // } elseif ($tanggalKedua) {
                    //     // Query jika hanya tanggal kedua yang ada
                    //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
                    // } else {
                    //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
                    //     $petugas = User::all();
                    // }

                    // $query = DB::table('peminjamans')
                    //     ->query();

                    if ($tanggalPertama && $tanggalKedua) {
                        $query = DB::table('peminjamans')->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                    } elseif ($tanggalPertama) {
                        $query = DB::table('peminjamans')->where('created_at', '>=', $tanggalPertama);
                    } elseif ($tanggalKedua) {
                        $query = DB::table('peminjamans')->where('created_at', '<=', $tanggalKedua);
                    }
                    // dd($query);

                    // if ($role) {
                    //     $query->where('role', $role);
                    //     dd($query);
                    // }

                    $peminjaman = $query->get();

                    // $petugas = DB::table('users')
                    // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
                    // ->get();
                    // dd($ruangan);

                    // $data = [$petugas];



                    $data = [
                        'peminjamans' => $peminjaman,
                        'kode_barcode' => $kode_barcode
                    ];
                    // }
                }
                $pdf = Pdf::loadView('petugas.layout.laporan.laporan-peminjaman-pdf', $data)->setPaper('a4', 'portrait');
                // return $pdf->download('invoice.pdf');
                return $pdf->stream('laporan-data-peminjaman.pdf');
            }

        }
    }
    //END PEMINJAMAN

    //MAINTENANCE
    public function goLaporanMaintenance()
    {

        $maintenances = DB::table('maintenances')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
            ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id')
            ->get();

        return view('petugas.layout.laporan.laporan-maintenance')->with([
            'title' => 'Laporan Data Maintenance',
            'active' => 'Laporan Data Maintenance',
            'open' => 'yes-3',
            'maintenances' => $maintenances,
            'requests' => null

        ]);

    }
    public function goLaporanMaintenanceFilter(Request $request)
    {
        // Jika $dates tidak ada atau kosong, tetapkan nilai default sebagai string kosong
        // $filter = urldecode($filter ?? '');

        $date = $request->query('date');



        $dateArray = explode('~', $date);

        $tanggalPertama = $dateArray[0] ?? null;
        $tanggalKedua = $dateArray[1] ?? null;

        // dd($dateArray);

        // // Validasi bahwa kedua tanggal ada
        // if ($tanggalPertama && $tanggalKedua) {
        //     // Query dengan whereBetween
        //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        // } elseif ($tanggalPertama) {
        //     // Query jika hanya tanggal pertama yang ada
        //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        // } elseif ($tanggalKedua) {
        //     // Query jika hanya tanggal kedua yang ada
        //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        // } else {
        //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //     $petugas = User::all();
        // }

        $query = maintenance::query();

        if ($tanggalPertama && $tanggalKedua) {
            $query->whereBetween('maintenances.created_at', [$tanggalPertama, $tanggalKedua])->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id');
        } elseif ($tanggalPertama) {
            $query->where('maintenances.created_at', '>=', $tanggalPertama)->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id');
        } elseif ($tanggalKedua) {
            $query->where('maintenances.created_at', '<=', $tanggalKedua)->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id');
        }
        // dd($query);

        // if ($role) {
        //     $query->where('role', $role);
        //     dd($query);
        // }

        $maintenance = $query->get();

        // $petugas = DB::table('users')
        // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        // ->get();


        return view('petugas.layout.laporan.laporan-maintenance')->with([
            'title' => 'Laporan Data Maintenance',
            'active' => 'Laporan Data Maintenance',
            'open' => 'yes-3',
            'maintenances' => $maintenance,
            'requests' => $request

        ]);
    }
    public function goLaporanMaintenancePdf(Request $request)
    {
        if ($request->getRequestUri() == "/print-data-maintenance-pdf?") {
            $maintenances = DB::table('maintenances')
                ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id', 'maintenances.tanggal_selesai')
                ->get();
            $data = [
                // 'pegawais' => $petugas,
                // 'assets' => $kategori_barang,
                'maintenances' => $maintenances
            ];
            $pdf = Pdf::loadView('petugas.layout.laporan.laporan-maintenance-pdf', $data)->setPaper('a4', 'portrait');
            // return $pdf->download('invoice.pdf');
            return $pdf->stream('laporan-data-maintenance.pdf');
        } else {
            if ($request->query('no_maintenance')) {
                $maintenances = DB::table('maintenances')
                    ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                    ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id', 'maintenances.tanggal_selesai')
                    ->where('no_maintenance', '=', $request->query('no_maintenance'))
                    ->get();
                $data = [
                    // 'pegawais' => $petugas,
                    // 'assets' => $kategori_barang,
                    'maintenances' => $maintenances
                ];
                $pdf = Pdf::loadView('petugas.layout.laporan.laporan-maintenance-pdf', $data)->setPaper('a4', 'portrait');
                // return $pdf->download('invoice.pdf');
                return $pdf->stream('laporan-data-maintenance.pdf');
            } else {
                if ($request->input('date') == null) {
                    $maintenances = DB::table('maintenances')
                        ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                        ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id', 'maintenances.tanggal_selesai')
                        ->get();
                    $data = [
                        'maintenances' => $maintenances
                    ];
                } else {

                    $date = $request->input('date');

                    $dateArray = explode('~', $date);

                    $tanggalPertama = $dateArray[0] ?? null;
                    $tanggalKedua = $dateArray[1] ?? null;

                    // dd($dateArray);

                    // // Validasi bahwa kedua tanggal ada
                    // if ($tanggalPertama && $tanggalKedua) {
                    //     // Query dengan whereBetween
                    //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
                    // } elseif ($tanggalPertama) {
                    //     // Query jika hanya tanggal pertama yang ada
                    //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
                    // } elseif ($tanggalKedua) {
                    //     // Query jika hanya tanggal kedua yang ada
                    //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
                    // } else {
                    //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
                    //     $petugas = User::all();
                    // }

                    $query = maintenance::query();

                    if ($tanggalPertama && $tanggalKedua) {
                        $query->whereBetween('maintenances.created_at', [$tanggalPertama, $tanggalKedua])->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                            ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id', 'maintenances.tanggal_selesai');
                    } elseif ($tanggalPertama) {
                        $query->where('maintenances.created_at', '>=', $tanggalPertama)->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                            ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id', 'maintenances.tanggal_selesai');
                    } elseif ($tanggalKedua) {
                        $query->where('maintenances.created_at', '<=', $tanggalKedua)->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                            ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id', 'maintenances.tanggal_selesai');
                    }
                    // dd($query);

                    // if ($role) {
                    //     $query->where('role', $role);
                    //     dd($query);
                    // }

                    $maintenance = $query->get();

                    // $petugas = DB::table('users')
                    // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
                    // ->get();
                    // dd($ruangan);

                    // $data = [$petugas];



                    $data = [
                        // 'pegawais' => $petugas,
                        // 'assets' => $kategori_barang,
                        'maintenances' => $maintenance
                    ];
                    // }
                }
                $pdf = Pdf::loadView('petugas.layout.laporan.laporan-maintenance-pdf', $data)->setPaper('a4', 'portrait');
                // return $pdf->download('invoice.pdf');
                return $pdf->stream('laporan-data-maintenance.pdf');
            }

        }


    }
    //END MAINTENANCE

    //PENGHAPUSAN
    public function goLaporanPenghapusan()
    {

        $penghapusans = DB::table('penghapusans')
            ->select('*')
            ->get();


        return view('petugas.layout.laporan.laporan-penghapusan')->with([
            'title' => 'Laporan Data Penghapusan',
            'active' => 'Laporan Data Penghapusan',
            'open' => 'yes-3',
            'penghapusans' => $penghapusans,
            'requests' => null

        ]);
    }
    public function goLaporanPenghapusanFilter(Request $request)
    {
        // Jika $dates tidak ada atau kosong, tetapkan nilai default sebagai string kosong
        // $filter = urldecode($filter ?? '');

        $date = $request->query('date');



        $dateArray = explode('~', $date);

        $tanggalPertama = $dateArray[0] ?? null;
        $tanggalKedua = $dateArray[1] ?? null;

        // dd($dateArray);

        // // Validasi bahwa kedua tanggal ada
        // if ($tanggalPertama && $tanggalKedua) {
        //     // Query dengan whereBetween
        //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        // } elseif ($tanggalPertama) {
        //     // Query jika hanya tanggal pertama yang ada
        //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        // } elseif ($tanggalKedua) {
        //     // Query jika hanya tanggal kedua yang ada
        //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        // } else {
        //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //     $petugas = User::all();
        // }

        $query = penghapusan::query();

        if ($tanggalPertama && $tanggalKedua) {
            $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        } elseif ($tanggalPertama) {
            $query->where('created_at', '>=', $tanggalPertama);
        } elseif ($tanggalKedua) {
            $query->where('created_at', '<=', $tanggalKedua);
        }
        // dd($query);

        // if ($role) {
        //     $query->where('role', $role);
        //     dd($query);
        // }

        $penghapusan = $query->get();

        // $petugas = DB::table('users')
        // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        // ->get();


        return view('petugas.layout.laporan.laporan-penghapusan')->with([
            'title' => 'Laporan Data Penghapusan',
            'active' => 'Laporan Data Penghapusan',
            'open' => 'yes-3',
            'penghapusans' => $penghapusan,
            'requests' => $request

        ]);
    }
    public function goLaporanPenghapusanPdf(Request $request)
    {
        if ($request->getRequestUri() == "/print-data-penghapusan-pdf?") {
            $data = [
                // 'pegawais' => $petugas,
                // 'assets' => $kategori_barang,
                'penghapusans' => penghapusan::all()
            ];
            $pdf = Pdf::loadView('petugas.layout.laporan.laporan-penghapusan-pdf', $data)->setPaper('a4', 'portrait');
            // return $pdf->download('invoice.pdf');
            return $pdf->stream('laporan-data-penghapusan.pdf');
        } else {
            if ($request->query('no_penghapusan')) {
                $penghapusans = penghapusan::select('*')
                    ->where('no_penghapusan', '=', $request->query('no_penghapusan'))
                    ->get();
                $data = [
                    // 'pegawais' => $petugas,
                    // 'assets' => $kategori_barang,
                    'penghapusans' => $penghapusans
                ];
                $pdf = Pdf::loadView('petugas.layout.laporan.laporan-penghapusan-pdf', $data)->setPaper('a4', 'portrait');
                // return $pdf->download('invoice.pdf');
                return $pdf->stream('laporan-data-penghapusan.pdf');
            } else {
                if ($request->input('date') == null) {
                    $data = [
                        'penghapusans' => penghapusan::all(),
                    ];
                } else {

                    $date = $request->input('date');

                    $dateArray = explode('~', $date);

                    $tanggalPertama = $dateArray[0] ?? null;
                    $tanggalKedua = $dateArray[1] ?? null;

                    // dd($dateArray);

                    // // Validasi bahwa kedua tanggal ada
                    // if ($tanggalPertama && $tanggalKedua) {
                    //     // Query dengan whereBetween
                    //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
                    // } elseif ($tanggalPertama) {
                    //     // Query jika hanya tanggal pertama yang ada
                    //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
                    // } elseif ($tanggalKedua) {
                    //     // Query jika hanya tanggal kedua yang ada
                    //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
                    // } else {
                    //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
                    //     $petugas = User::all();
                    // }

                    $query = penghapusan::query();

                    if ($tanggalPertama && $tanggalKedua) {
                        $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                    } elseif ($tanggalPertama) {
                        $query->where('created_at', '>=', $tanggalPertama);
                    } elseif ($tanggalKedua) {
                        $query->where('created_at', '<=', $tanggalKedua);
                    }
                    // dd($query);

                    // if ($role) {
                    //     $query->where('role', $role);
                    //     dd($query);
                    // }

                    $penghapusan = $query->get();

                    // $petugas = DB::table('users')
                    // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
                    // ->get();
                    // dd($ruangan);

                    // $data = [$petugas];



                    $data = [
                        // 'pegawais' => $petugas,
                        // 'assets' => $kategori_barang,
                        'penghapusans' => $penghapusan
                    ];
                    // }
                }
                $pdf = Pdf::loadView('petugas.layout.laporan.laporan-penghapusan-pdf', $data)->setPaper('a4', 'portrait');
                // return $pdf->download('invoice.pdf');
                return $pdf->stream('laporan-data-penghapusan.pdf');
            }

        }
    }
    //END PENGHAPUSAN


    //AKTIVA
    public function goAktiva()
    {
        $cekTipe = DB::table('tipe_ruangans')->count();

        return view('petugas.layout.aktiva')->with([
            'title' => 'Data Aktiva / Fasilitas Ruangan',
            'active' => 'Data Aktiva / Fasilitas Ruangan',
            'cek' => $cekTipe,
            'ruangans' => ruangan::all(),
            'open' => 'no',
        ]);
    }
    public function goLaporanAktivaPdf(Request $request)
    {
        $assets = DB::table('detail_penempatans')
            ->select('*')
            ->join(
                'penempatans',
                'penempatans.no_penempatan',
                '=',
                'detail_penempatans.no_penempatan',
            )
            ->join(
                'detail_barangs',
                'detail_barangs.kode_barcode',
                '=',
                'detail_penempatans.kode_barcode',
            )
            ->where('no_ruangan', $request->query('no_ruangan'))
            ->get();
        $assets_count = DB::table('detail_penempatans')
            ->select('*')
            ->join(
                'penempatans',
                'penempatans.no_penempatan',
                '=',
                'detail_penempatans.no_penempatan',
            )
            ->join(
                'detail_barangs',
                'detail_barangs.kode_barcode',
                '=',
                'detail_penempatans.kode_barcode',
            )
            ->where('no_ruangan', $request->query('no_ruangan'))
            ->count();

        $data = [
            'assets' => $assets,
            'no_ruangan' => $request->query('no_ruangan'),
            'count' => $assets_count
        ];
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-aktiva-ruangan-pdf', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('laporan-data-petugas.pdf');
    }
    //END AKTIVA

    //ASSETS
    public function goAssets()
    {

        $barang = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();

        return view('petugas.layout.assets')->with([
            'title' => 'Data Assets',
            'active' => 'Data Assets',
            'barangs' => $barang,
            'open' => 'no',
        ]);
    }
    public function goLaporanAssetsPdf(Request $request)
    {
        $assets = DB::table('barangs')
            ->select('*')
            ->join(
                'detail_barangs',
                'detail_barangs.no_barang',
                '=',
                'barangs.no_barang',
            )
            ->where('detail_barangs.no_barang', $request->query('no_barang'))
            ->get();
        $assets_count = DB::table('barangs')
            ->select('*')
            ->join(
                'detail_barangs',
                'detail_barangs.no_barang',
                '=',
                'barangs.no_barang',
            )
            ->where('detail_barangs.no_barang', $request->query('no_barang'))
            ->count();

        $data = [
            'assets' => $assets,
            'no_barang' => $request->query('no_barang'),
            'count' => $assets_count
        ];
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-assets-pdf', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('laporan-data-asset.pdf');
    }
    //END ASSETS

    //BARCODE
    public function goBarcodeAllPdf(Request $request)
    {
        if ($request->query('no_pengadaan')) {
            $assets = DB::table('detail_barangs')
                ->select('*')
                ->where('no_pengadaan', '=', $request->query('no_pengadaan'))
                ->get();
            // $assets_count = DB::table('detail_barangs')
            // ->select('*')
            // ->where('no_pengadaan','=', $request->query('no_pengadaan'))
            // ->count();

            // dd($request->query('no_pengadaan'));
            $data = [
                'assets' => $assets,
                // 'count' => $assets_count
            ];
            $pdf = Pdf::loadView('petugas.layout.laporan.barcodeall-pdf', $data)->setPaper('a4', 'landscape');
            return $pdf->stream('barcode.pdf');
        } else {
            $assets = DB::table('detail_barangs')
                ->select('*')
                ->where('kode_barcode', '=', $request->query('barcode'))
                ->get();
            // $assets_count = DB::table('detail_barangs')
            // ->select('*')
            // ->where('no_pengadaan','=', $request->query('no_pengadaan'))
            // ->count();

            // dd($request->query('no_pengadaan'));
            $data = [
                'assets' => $assets,
                // 'count' => $assets_count
            ];
            $pdf = Pdf::loadView('petugas.layout.laporan.barcodeall-pdf', $data)->setPaper('a4', 'landscape');
            return $pdf->stream('barcode.pdf');
        }

    }
    //END BARCODE
}