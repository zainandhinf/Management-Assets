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
    public function goLaporanPegawaiPdf(Request $request)
    {
        // if ($request->input('date') == null && $request->input('role') == null) {
        //     $data = [
        //         'petugass' => User::all(),
        //     ];
        // } else {

        //     $date = $request->input('date');
        //     $role = $request->input('role');


        //     if ($role == "koordinator" || $role == "super_user") {
        //         if ($role == "koordinator") {
        //             $petugas = DB::table('users')->where('role', 'petugas')->get();
        //         } else {
        //             $petugas = DB::table('users')->where('role', $role)->get();
        //         }
        //     } else {
        //         $dateArray = explode('~', $date);

        //         $tanggalPertama = $dateArray[0] ?? null;
        //         $tanggalKedua = $dateArray[1] ?? null;

        //         if ($role == "koordinator") {
        //             $role = "petugas";
        //         }

        //         // dd($dateArray);

        //         // // Validasi bahwa kedua tanggal ada
        //         // if ($tanggalPertama && $tanggalKedua) {
        //         //     // Query dengan whereBetween
        //         //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        //         // } elseif ($tanggalPertama) {
        //         //     // Query jika hanya tanggal pertama yang ada
        //         //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        //         // } elseif ($tanggalKedua) {
        //         //     // Query jika hanya tanggal kedua yang ada
        //         //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        //         // } else {
        //         //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //         //     $petugas = User::all();
        //         // }

        //         $query = User::query();

        //         if ($tanggalPertama && $tanggalKedua && $role) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role);
        //         } else if ($tanggalPertama && $tanggalKedua) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        //         } elseif ($tanggalPertama && $role) {
        //             $query->where('created_at', '>=', $tanggalPertama)->where('role', $role);
        //         } elseif ($tanggalPertama) {
        //             $query->where('created_at', '>=', $tanggalPertama);
        //         } elseif ($tanggalKedua && $role) {
        //             $query->where('created_at', '<=', $tanggalKedua)->where('role', $role);
        //         } elseif ($tanggalKedua) {
        //             $query->where('created_at', '<=', $tanggalKedua);
        //         }
        //         // dd($query);

        //         // if ($role) {
        //         //     $query->where('role', $role);
        //         //     dd($query);
        //         // }

        //         $petugas = $query->get();

        //         // $petugas = DB::table('users')
        //         // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        //         // ->get();
        //     }

        // $data = [$petugas];
        $data = [
            // 'pegawais' => $petugas,
            'pegawais' => pegawai::all()
        ];
        // }
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-pegawai-pdf', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('invoice.pdf');
        return $pdf->stream('laporan-data-pegawai.pdf');
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
    public function goLaporanBarangPdf(Request $request)
    {
        // if ($request->input('date') == null && $request->input('role') == null) {
        //     $data = [
        //         'petugass' => User::all(),
        //     ];
        // } else {

        //     $date = $request->input('date');
        //     $role = $request->input('role');


        //     if ($role == "koordinator" || $role == "super_user") {
        //         if ($role == "koordinator") {
        //             $petugas = DB::table('users')->where('role', 'petugas')->get();
        //         } else {
        //             $petugas = DB::table('users')->where('role', $role)->get();
        //         }
        //     } else {
        //         $dateArray = explode('~', $date);

        //         $tanggalPertama = $dateArray[0] ?? null;
        //         $tanggalKedua = $dateArray[1] ?? null;

        //         if ($role == "koordinator") {
        //             $role = "petugas";
        //         }

        //         // dd($dateArray);

        //         // // Validasi bahwa kedua tanggal ada
        //         // if ($tanggalPertama && $tanggalKedua) {
        //         //     // Query dengan whereBetween
        //         //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        //         // } elseif ($tanggalPertama) {
        //         //     // Query jika hanya tanggal pertama yang ada
        //         //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        //         // } elseif ($tanggalKedua) {
        //         //     // Query jika hanya tanggal kedua yang ada
        //         //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        //         // } else {
        //         //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //         //     $petugas = User::all();
        //         // }

        //         $query = User::query();

        //         if ($tanggalPertama && $tanggalKedua && $role) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role);
        //         } else if ($tanggalPertama && $tanggalKedua) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        //         } elseif ($tanggalPertama && $role) {
        //             $query->where('created_at', '>=', $tanggalPertama)->where('role', $role);
        //         } elseif ($tanggalPertama) {
        //             $query->where('created_at', '>=', $tanggalPertama);
        //         } elseif ($tanggalKedua && $role) {
        //             $query->where('created_at', '<=', $tanggalKedua)->where('role', $role);
        //         } elseif ($tanggalKedua) {
        //             $query->where('created_at', '<=', $tanggalKedua);
        //         }
        //         // dd($query);

        //         // if ($role) {
        //         //     $query->where('role', $role);
        //         //     dd($query);
        //         // }

        //         $petugas = $query->get();

        //         // $petugas = DB::table('users')
        //         // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        //         // ->get();
        //     }

        // $data = [$petugas];

        $cekKategori = DB::table('kategori_barangs')->count();

        $barangs = barang::all();

        $kategori_barang = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();
        $data = [
            // 'pegawais' => $petugas,
            // 'assets' => $kategori_barang,
            'barangs' => $kategori_barang
        ];
        // }
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
    public function goLaporanRuanganPdf(Request $request)
    {
        // if ($request->input('date') == null && $request->input('role') == null) {
        //     $data = [
        //         'petugass' => User::all(),
        //     ];
        // } else {

        //     $date = $request->input('date');
        //     $role = $request->input('role');


        //     if ($role == "koordinator" || $role == "super_user") {
        //         if ($role == "koordinator") {
        //             $petugas = DB::table('users')->where('role', 'petugas')->get();
        //         } else {
        //             $petugas = DB::table('users')->where('role', $role)->get();
        //         }
        //     } else {
        //         $dateArray = explode('~', $date);

        //         $tanggalPertama = $dateArray[0] ?? null;
        //         $tanggalKedua = $dateArray[1] ?? null;

        //         if ($role == "koordinator") {
        //             $role = "petugas";
        //         }

        //         // dd($dateArray);

        //         // // Validasi bahwa kedua tanggal ada
        //         // if ($tanggalPertama && $tanggalKedua) {
        //         //     // Query dengan whereBetween
        //         //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        //         // } elseif ($tanggalPertama) {
        //         //     // Query jika hanya tanggal pertama yang ada
        //         //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        //         // } elseif ($tanggalKedua) {
        //         //     // Query jika hanya tanggal kedua yang ada
        //         //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        //         // } else {
        //         //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //         //     $petugas = User::all();
        //         // }

        //         $query = User::query();

        //         if ($tanggalPertama && $tanggalKedua && $role) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role);
        //         } else if ($tanggalPertama && $tanggalKedua) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        //         } elseif ($tanggalPertama && $role) {
        //             $query->where('created_at', '>=', $tanggalPertama)->where('role', $role);
        //         } elseif ($tanggalPertama) {
        //             $query->where('created_at', '>=', $tanggalPertama);
        //         } elseif ($tanggalKedua && $role) {
        //             $query->where('created_at', '<=', $tanggalKedua)->where('role', $role);
        //         } elseif ($tanggalKedua) {
        //             $query->where('created_at', '<=', $tanggalKedua);
        //         }
        //         // dd($query);

        //         // if ($role) {
        //         //     $query->where('role', $role);
        //         //     dd($query);
        //         // }

        //         $petugas = $query->get();

        //         // $petugas = DB::table('users')
        //         // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        //         // ->get();
        //     }

        // $data = [$petugas];

        if ($request->query('no_ruangan')) {
            $ruangans = ruangan::join('tipe_ruangans', 'tipe_ruangans.id', '=', 'ruangans.tipe_ruangan')
                ->select('ruangans.*', 'tipe_ruangans.nama_tipe')
                ->where('no_ruangan', '=', $request->query('no_ruangan'))
                ->get();
        } else {
            $ruangans = ruangan::join('tipe_ruangans', 'tipe_ruangans.id', '=', 'ruangans.tipe_ruangan')
                ->select('ruangans.*', 'tipe_ruangans.nama_tipe')
                ->get();
        }


        $data = [
            // 'pegawais' => $petugas,
            // 'assets' => $kategori_barang,
            'ruangans' => $ruangans
        ];
        // }
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-ruangan-pdf', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('invoice.pdf');
        return $pdf->stream('laporan-data-ruangan.pdf');
    }
    //END RUANGAN

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
    public function goLaporanPengadaanPdf(Request $request)
    {
        // if ($request->input('date') == null && $request->input('role') == null) {
        //     $data = [
        //         'petugass' => User::all(),
        //     ];
        // } else {

        //     $date = $request->input('date');
        //     $role = $request->input('role');


        //     if ($role == "koordinator" || $role == "super_user") {
        //         if ($role == "koordinator") {
        //             $petugas = DB::table('users')->where('role', 'petugas')->get();
        //         } else {
        //             $petugas = DB::table('users')->where('role', $role)->get();
        //         }
        //     } else {
        //         $dateArray = explode('~', $date);

        //         $tanggalPertama = $dateArray[0] ?? null;
        //         $tanggalKedua = $dateArray[1] ?? null;

        //         if ($role == "koordinator") {
        //             $role = "petugas";
        //         }

        //         // dd($dateArray);

        //         // // Validasi bahwa kedua tanggal ada
        //         // if ($tanggalPertama && $tanggalKedua) {
        //         //     // Query dengan whereBetween
        //         //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        //         // } elseif ($tanggalPertama) {
        //         //     // Query jika hanya tanggal pertama yang ada
        //         //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        //         // } elseif ($tanggalKedua) {
        //         //     // Query jika hanya tanggal kedua yang ada
        //         //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        //         // } else {
        //         //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //         //     $petugas = User::all();
        //         // }

        //         $query = User::query();

        //         if ($tanggalPertama && $tanggalKedua && $role) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role);
        //         } else if ($tanggalPertama && $tanggalKedua) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        //         } elseif ($tanggalPertama && $role) {
        //             $query->where('created_at', '>=', $tanggalPertama)->where('role', $role);
        //         } elseif ($tanggalPertama) {
        //             $query->where('created_at', '>=', $tanggalPertama);
        //         } elseif ($tanggalKedua && $role) {
        //             $query->where('created_at', '<=', $tanggalKedua)->where('role', $role);
        //         } elseif ($tanggalKedua) {
        //             $query->where('created_at', '<=', $tanggalKedua);
        //         }
        //         // dd($query);

        //         // if ($role) {
        //         //     $query->where('role', $role);
        //         //     dd($query);
        //         // }

        //         $petugas = $query->get();

        //         // $petugas = DB::table('users')
        //         // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        //         // ->get();
        //     }

        // $data = [$petugas];




        $detail_barang = DB::table('detail_barangs')
            ->join('pengadaans', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
            ->select('pengadaans.tanggal_pengadaan', 'detail_barangs.*')
            ->get();


        // dd($keranjang);

        if ($request->query('no_pengadaan')) {
            $pengadaans = pengadaan::join('detail_barangs', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
                ->select('*')
                ->where('pengadaans.no_pengadaan', '=', $request->query('no_pengadaan'))
                ->get();
        } else {
            $pengadaans = pengadaan::join('detail_barangs', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
                ->select('*')
                // ->where('pengadaans.no_pengadaan', '=', $request->query('no_pengadaan'))
                ->get();
        }


        $data = [
            // 'pegawais' => $petugas,
            // 'assets' => $kategori_barang,
            'pengadaans' => $pengadaans
        ];
        // }
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-pengadaan-pdf', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('invoice.pdf');
        return $pdf->stream('laporan-data-pengadaan.pdf');
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
    public function goLaporanPenempatanPdf(Request $request)
    {
        // if ($request->input('date') == null && $request->input('role') == null) {
        //     $data = [
        //         'petugass' => User::all(),
        //     ];
        // } else {

        //     $date = $request->input('date');
        //     $role = $request->input('role');


        //     if ($role == "koordinator" || $role == "super_user") {
        //         if ($role == "koordinator") {
        //             $petugas = DB::table('users')->where('role', 'petugas')->get();
        //         } else {
        //             $petugas = DB::table('users')->where('role', $role)->get();
        //         }
        //     } else {
        //         $dateArray = explode('~', $date);

        //         $tanggalPertama = $dateArray[0] ?? null;
        //         $tanggalKedua = $dateArray[1] ?? null;

        //         if ($role == "koordinator") {
        //             $role = "petugas";
        //         }

        //         // dd($dateArray);

        //         // // Validasi bahwa kedua tanggal ada
        //         // if ($tanggalPertama && $tanggalKedua) {
        //         //     // Query dengan whereBetween
        //         //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        //         // } elseif ($tanggalPertama) {
        //         //     // Query jika hanya tanggal pertama yang ada
        //         //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        //         // } elseif ($tanggalKedua) {
        //         //     // Query jika hanya tanggal kedua yang ada
        //         //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        //         // } else {
        //         //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //         //     $petugas = User::all();
        //         // }

        //         $query = User::query();

        //         if ($tanggalPertama && $tanggalKedua && $role) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role);
        //         } else if ($tanggalPertama && $tanggalKedua) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        //         } elseif ($tanggalPertama && $role) {
        //             $query->where('created_at', '>=', $tanggalPertama)->where('role', $role);
        //         } elseif ($tanggalPertama) {
        //             $query->where('created_at', '>=', $tanggalPertama);
        //         } elseif ($tanggalKedua && $role) {
        //             $query->where('created_at', '<=', $tanggalKedua)->where('role', $role);
        //         } elseif ($tanggalKedua) {
        //             $query->where('created_at', '<=', $tanggalKedua);
        //         }
        //         // dd($query);

        //         // if ($role) {
        //         //     $query->where('role', $role);
        //         //     dd($query);
        //         // }

        //         $petugas = $query->get();

        //         // $petugas = DB::table('users')
        //         // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        //         // ->get();
        //     }

        // $data = [$petugas];




        $detail_barang = DB::table('detail_barangs')
            ->join('pengadaans', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
            ->select('pengadaans.tanggal_pengadaan', 'detail_barangs.*')
            ->get();


        // dd($keranjang);

        if ($request->query('no_penempatan')) {
            $penempatans = penempatan::select('*')
                ->where('no_penempatan', '=', $request->query('no_penempatan'))
                ->get();
        } else {
            $penempatans = penempatan::select('*')
                // ->where('pengadaans.no_pengadaan', '=', $request->query('no_pengadaan'))
                ->get();
        }


        $data = [
            // 'pegawais' => $petugas,
            // 'assets' => $kategori_barang,
            'penempatans' => $penempatans
        ];
        // }
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-penempatan-pdf', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('invoice.pdf');
        return $pdf->stream('laporan-data-penempatan.pdf');
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
    public function goLaporanMutasiPdf(Request $request)
    {
        // if ($request->input('date') == null && $request->input('role') == null) {
        //     $data = [
        //         'petugass' => User::all(),
        //     ];
        // } else {

        //     $date = $request->input('date');
        //     $role = $request->input('role');


        //     if ($role == "koordinator" || $role == "super_user") {
        //         if ($role == "koordinator") {
        //             $petugas = DB::table('users')->where('role', 'petugas')->get();
        //         } else {
        //             $petugas = DB::table('users')->where('role', $role)->get();
        //         }
        //     } else {
        //         $dateArray = explode('~', $date);

        //         $tanggalPertama = $dateArray[0] ?? null;
        //         $tanggalKedua = $dateArray[1] ?? null;

        //         if ($role == "koordinator") {
        //             $role = "petugas";
        //         }

        //         // dd($dateArray);

        //         // // Validasi bahwa kedua tanggal ada
        //         // if ($tanggalPertama && $tanggalKedua) {
        //         //     // Query dengan whereBetween
        //         //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        //         // } elseif ($tanggalPertama) {
        //         //     // Query jika hanya tanggal pertama yang ada
        //         //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        //         // } elseif ($tanggalKedua) {
        //         //     // Query jika hanya tanggal kedua yang ada
        //         //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        //         // } else {
        //         //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //         //     $petugas = User::all();
        //         // }

        //         $query = User::query();

        //         if ($tanggalPertama && $tanggalKedua && $role) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role);
        //         } else if ($tanggalPertama && $tanggalKedua) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        //         } elseif ($tanggalPertama && $role) {
        //             $query->where('created_at', '>=', $tanggalPertama)->where('role', $role);
        //         } elseif ($tanggalPertama) {
        //             $query->where('created_at', '>=', $tanggalPertama);
        //         } elseif ($tanggalKedua && $role) {
        //             $query->where('created_at', '<=', $tanggalKedua)->where('role', $role);
        //         } elseif ($tanggalKedua) {
        //             $query->where('created_at', '<=', $tanggalKedua);
        //         }
        //         // dd($query);

        //         // if ($role) {
        //         //     $query->where('role', $role);
        //         //     dd($query);
        //         // }

        //         $petugas = $query->get();

        //         // $petugas = DB::table('users')
        //         // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        //         // ->get();
        //     }

        // $data = [$petugas];




        $detail_barang = DB::table('detail_barangs')
            ->join('pengadaans', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
            ->select('pengadaans.tanggal_pengadaan', 'detail_barangs.*')
            ->get();


        // dd($keranjang);

        if ($request->query('no_mutasi')) {
            $mutasis = mutasi::select('*')
                ->where('no_mutasi', '=', $request->query('no_mutasi'))
                ->get();
        } else {
            $mutasis = mutasi::select('*')
                // ->where('pengadaans.no_pengadaan', '=', $request->query('no_pengadaan'))
                ->get();
        }


        $data = [
            // 'pegawais' => $petugas,
            // 'assets' => $kategori_barang,
            'mutasis' => $mutasis
        ];
        // }
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-mutasi-pdf', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('invoice.pdf');
        return $pdf->stream('laporan-data-mutasi.pdf');
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
    public function goLaporanPeminjamanPdf(Request $request)
    {
        // if ($request->input('date') == null && $request->input('role') == null) {
        //     $data = [
        //         'petugass' => User::all(),
        //     ];
        // } else {

        //     $date = $request->input('date');
        //     $role = $request->input('role');


        //     if ($role == "koordinator" || $role == "super_user") {
        //         if ($role == "koordinator") {
        //             $petugas = DB::table('users')->where('role', 'petugas')->get();
        //         } else {
        //             $petugas = DB::table('users')->where('role', $role)->get();
        //         }
        //     } else {
        //         $dateArray = explode('~', $date);

        //         $tanggalPertama = $dateArray[0] ?? null;
        //         $tanggalKedua = $dateArray[1] ?? null;

        //         if ($role == "koordinator") {
        //             $role = "petugas";
        //         }

        //         // dd($dateArray);

        //         // // Validasi bahwa kedua tanggal ada
        //         // if ($tanggalPertama && $tanggalKedua) {
        //         //     // Query dengan whereBetween
        //         //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        //         // } elseif ($tanggalPertama) {
        //         //     // Query jika hanya tanggal pertama yang ada
        //         //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        //         // } elseif ($tanggalKedua) {
        //         //     // Query jika hanya tanggal kedua yang ada
        //         //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        //         // } else {
        //         //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //         //     $petugas = User::all();
        //         // }

        //         $query = User::query();

        //         if ($tanggalPertama && $tanggalKedua && $role) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role);
        //         } else if ($tanggalPertama && $tanggalKedua) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        //         } elseif ($tanggalPertama && $role) {
        //             $query->where('created_at', '>=', $tanggalPertama)->where('role', $role);
        //         } elseif ($tanggalPertama) {
        //             $query->where('created_at', '>=', $tanggalPertama);
        //         } elseif ($tanggalKedua && $role) {
        //             $query->where('created_at', '<=', $tanggalKedua)->where('role', $role);
        //         } elseif ($tanggalKedua) {
        //             $query->where('created_at', '<=', $tanggalKedua);
        //         }
        //         // dd($query);

        //         // if ($role) {
        //         //     $query->where('role', $role);
        //         //     dd($query);
        //         // }

        //         $petugas = $query->get();

        //         // $petugas = DB::table('users')
        //         // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        //         // ->get();
        //     }

        // $data = [$petugas];




        $detail_barang = DB::table('detail_barangs')
            ->join('pengadaans', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
            ->select('pengadaans.tanggal_pengadaan', 'detail_barangs.*')
            ->get();


        // dd($keranjang);

        if ($request->query('no_peminjaman') || $request->query('kode_barcode')) {
            $peminjamans = DB::table('peminjamans')
                ->select('*')
                ->where('no_peminjaman', '=', $request->query('no_peminjaman'))
                ->get();
            $kode_barcode = $request->query('kode_barcode');
        } else {
            $peminjamans = DB::table('peminjamans')
                ->select('*')
                // ->where('pengadaans.no_pengadaan', '=', $request->query('no_pengadaan'))
                ->get();
            $kode_barcode = null;
        }


        $data = [
            // 'pegawais' => $petugas,
            // 'assets' => $kategori_barang,
            'peminjamans' => $peminjamans,
            'kode_barcode' => $kode_barcode
        ];
        // }
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-peminjaman-pdf', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('invoice.pdf');
        return $pdf->stream('laporan-data-peminjaman.pdf');
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
    public function goLaporanMaintenancePdf(Request $request)
    {
        // if ($request->input('date') == null && $request->input('role') == null) {
        //     $data = [
        //         'petugass' => User::all(),
        //     ];
        // } else {

        //     $date = $request->input('date');
        //     $role = $request->input('role');


        //     if ($role == "koordinator" || $role == "super_user") {
        //         if ($role == "koordinator") {
        //             $petugas = DB::table('users')->where('role', 'petugas')->get();
        //         } else {
        //             $petugas = DB::table('users')->where('role', $role)->get();
        //         }
        //     } else {
        //         $dateArray = explode('~', $date);

        //         $tanggalPertama = $dateArray[0] ?? null;
        //         $tanggalKedua = $dateArray[1] ?? null;

        //         if ($role == "koordinator") {
        //             $role = "petugas";
        //         }

        //         // dd($dateArray);

        //         // // Validasi bahwa kedua tanggal ada
        //         // if ($tanggalPertama && $tanggalKedua) {
        //         //     // Query dengan whereBetween
        //         //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        //         // } elseif ($tanggalPertama) {
        //         //     // Query jika hanya tanggal pertama yang ada
        //         //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        //         // } elseif ($tanggalKedua) {
        //         //     // Query jika hanya tanggal kedua yang ada
        //         //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        //         // } else {
        //         //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //         //     $petugas = User::all();
        //         // }

        //         $query = User::query();

        //         if ($tanggalPertama && $tanggalKedua && $role) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role);
        //         } else if ($tanggalPertama && $tanggalKedua) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        //         } elseif ($tanggalPertama && $role) {
        //             $query->where('created_at', '>=', $tanggalPertama)->where('role', $role);
        //         } elseif ($tanggalPertama) {
        //             $query->where('created_at', '>=', $tanggalPertama);
        //         } elseif ($tanggalKedua && $role) {
        //             $query->where('created_at', '<=', $tanggalKedua)->where('role', $role);
        //         } elseif ($tanggalKedua) {
        //             $query->where('created_at', '<=', $tanggalKedua);
        //         }
        //         // dd($query);

        //         // if ($role) {
        //         //     $query->where('role', $role);
        //         //     dd($query);
        //         // }

        //         $petugas = $query->get();

        //         // $petugas = DB::table('users')
        //         // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        //         // ->get();
        //     }

        // $data = [$petugas];




        $detail_barang = DB::table('detail_barangs')
            ->join('pengadaans', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
            ->select('pengadaans.tanggal_pengadaan', 'detail_barangs.*')
            ->get();



        if ($request->query('no_maintenance')) {
            $maintenances = DB::table('maintenances')
            ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
            ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id', 'maintenances.tanggal_selesai')
            ->where('no_maintenance', '=', $request->query('no_maintenance'))
            ->get();
        } else {
            $maintenances = DB::table('maintenances')
                ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id', 'maintenances.tanggal_selesai')
                ->get();
        }

        // dd($maintenances);

        $data = [
            // 'pegawais' => $petugas,
            // 'assets' => $kategori_barang,
            'maintenances' => $maintenances
        ];
        // }
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-maintenance-pdf', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('invoice.pdf');
        return $pdf->stream('laporan-data-maintenance.pdf');
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
    public function goLaporanPenghapusanPdf(Request $request)
    {
        // if ($request->input('date') == null && $request->input('role') == null) {
        //     $data = [
        //         'petugass' => User::all(),
        //     ];
        // } else {

        //     $date = $request->input('date');
        //     $role = $request->input('role');


        //     if ($role == "koordinator" || $role == "super_user") {
        //         if ($role == "koordinator") {
        //             $petugas = DB::table('users')->where('role', 'petugas')->get();
        //         } else {
        //             $petugas = DB::table('users')->where('role', $role)->get();
        //         }
        //     } else {
        //         $dateArray = explode('~', $date);

        //         $tanggalPertama = $dateArray[0] ?? null;
        //         $tanggalKedua = $dateArray[1] ?? null;

        //         if ($role == "koordinator") {
        //             $role = "petugas";
        //         }

        //         // dd($dateArray);

        //         // // Validasi bahwa kedua tanggal ada
        //         // if ($tanggalPertama && $tanggalKedua) {
        //         //     // Query dengan whereBetween
        //         //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
        //         // } elseif ($tanggalPertama) {
        //         //     // Query jika hanya tanggal pertama yang ada
        //         //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
        //         // } elseif ($tanggalKedua) {
        //         //     // Query jika hanya tanggal kedua yang ada
        //         //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
        //         // } else {
        //         //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
        //         //     $petugas = User::all();
        //         // }

        //         $query = User::query();

        //         if ($tanggalPertama && $tanggalKedua && $role) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role);
        //         } else if ($tanggalPertama && $tanggalKedua) {
        //             $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        //         } elseif ($tanggalPertama && $role) {
        //             $query->where('created_at', '>=', $tanggalPertama)->where('role', $role);
        //         } elseif ($tanggalPertama) {
        //             $query->where('created_at', '>=', $tanggalPertama);
        //         } elseif ($tanggalKedua && $role) {
        //             $query->where('created_at', '<=', $tanggalKedua)->where('role', $role);
        //         } elseif ($tanggalKedua) {
        //             $query->where('created_at', '<=', $tanggalKedua);
        //         }
        //         // dd($query);

        //         // if ($role) {
        //         //     $query->where('role', $role);
        //         //     dd($query);
        //         // }

        //         $petugas = $query->get();

        //         // $petugas = DB::table('users')
        //         // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
        //         // ->get();
        //     }

        // $data = [$petugas];




        $detail_barang = DB::table('detail_barangs')
            ->join('pengadaans', 'detail_barangs.no_pengadaan', '=', 'pengadaans.no_pengadaan')
            ->select('pengadaans.tanggal_pengadaan', 'detail_barangs.*')
            ->get();


        // dd($keranjang);

        if ($request->query('no_penghapusan')) {
            $penghapusans = penghapusan::select('*')
                ->where('no_penghapusan', '=', $request->query('no_penghapusan'))
                ->get();
        } else {
            $penghapusans = penghapusan::select('*')
                // ->where('pengadaans.no_pengadaan', '=', $request->query('no_pengadaan'))
                ->get();
        }


        $data = [
            // 'pegawais' => $petugas,
            // 'assets' => $kategori_barang,
            'penghapusans' => $penghapusans
        ];
        // }
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-penghapusan-pdf', $data)->setPaper('a4', 'portrait');
        // return $pdf->download('invoice.pdf');
        return $pdf->stream('laporan-data-penghapusan.pdf');
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
