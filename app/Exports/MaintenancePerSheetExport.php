<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Http\Request;
use App\Models\maintenance;

class MaintenancePerSheetExport implements FromView, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $no_maintenance;
    protected $request;

    public function __construct($no_maintenance, Request $request)
    {
        $this->no_maintenance = $no_maintenance;
        $this->request = $request;
    }

    public function view(): View
    {
        $maintenance_detail = DB::table('maintenances')
            ->where('no_maintenance', '=', $this->no_maintenance)
            ->first();
        // Ambil data barang berdasarkan ruangan
        // $barang = DB::table('detail_barangs')
        // ->
        //     ->where('ruangan_id', $this->ruanganId)
        //     ->get();
        $date = $this->request->query('date');

        if ($this->request->getRequestUri() == "/print-data-maintenance-pdf?") {
            $maintenance = DB::table('maintenances')
                ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id', 'maintenances.tanggal_selesai')
                ->get();
            $maintenances = DB::table('maintenances')->where('no_maintenance', $this->no_maintenance)->first();

            return view('petugas.layout.laporan.laporan-maintenance-excel', [
                'maintenance' => $maintenance,
                'maintenance_detail' => $maintenance_detail,
                'maintenances' => $maintenances->no_maintenance
            ]);
        } else {
            if ($this->request->query('no_maintenance')) {
                $maintenance = DB::table('maintenances')
                    ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                    ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id', 'maintenances.tanggal_selesai')
                    ->where('no_maintenance', '=', $this->request->query('no_maintenance'))
                    ->get();
                $maintenances = DB::table('maintenances')->where('no_maintenance', $this->no_maintenance)->first();

                return view('petugas.layout.laporan.laporan-maintenance-excel', [
                    'maintenance' => $maintenance,
                    'maintenance_detail' => $maintenance_detail,
                    'maintenances' => $maintenances->no_maintenance
                ]);
            } else {
                if ($this->request->input('date') == null) {
                    $maintenance = DB::table('maintenances')
                        ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'maintenances.kode_barcode')
                        ->select('detail_barangs.*', 'maintenances.status as status_maintenance', 'maintenances.keterangan as keterangan_maintenance', 'maintenances.no_maintenance', 'maintenances.tanggal_maintenance', 'maintenances.biaya', 'maintenances.user_id', 'maintenances.tanggal_selesai')
                        ->get();
                    $maintenances = DB::table('maintenances')->where('no_maintenance', $this->no_maintenance)->first();

                    return view('petugas.layout.laporan.laporan-maintenance-excel', [
                        'maintenance' => $maintenance,
                        'maintenance_detail' => $maintenance_detail,
                        'maintenances' => $maintenances->no_maintenance
                    ]);
                } else {

                    $date = $this->request->input('date');

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



                    $maintenances = DB::table('maintenances')->where('no_maintenance', $this->no_maintenance)->first();

                    return view('petugas.layout.laporan.laporan-maintenance-excel', [
                        'maintenance' => $maintenance,
                        'maintenance_detail' => $maintenance_detail,
                        'maintenances' => $maintenances->no_maintenance
                    ]);
                }
            }

        }

    }

    public function title(): string
    {
        // Ambil nama ruangan dari database
        $maintenance = DB::table('maintenances')->where('no_maintenance', $this->no_maintenance)->first();
        return $maintenance->no_maintenance;
    }
}
