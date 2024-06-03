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
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-petugas-pdf', $data);
        // return $pdf->download('invoice.pdf');
        return $pdf->stream('laporan-data-petugas.pdf');
    }
    //END PETUGAS


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
        $pdf = Pdf::loadView('petugas.layout.laporan.laporan-aktiva-ruangan-pdf', $data);
        return $pdf->stream('laporan-data-petugas.pdf');
    }
    //END AKTIVA
}
