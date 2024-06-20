<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Http\Request;
use App\Models\pengadaan;

class PengadaanPerSheetExport implements FromView, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $no_pengadaan;
    protected $request;

    public function __construct($no_pengadaan, Request $request)
    {
        $this->no_pengadaan = $no_pengadaan;
        $this->request = $request;
    }

    public function view(): View
    {
        $pengadaan_detail = DB::table('pengadaans')
            ->where('no_pengadaan', '=', $this->no_pengadaan)
            ->first();
        // Ambil data barang berdasarkan ruangan
        // $barang = DB::table('detail_barangs')
        // ->
        //     ->where('ruangan_id', $this->ruanganId)
        //     ->get();
        $date = $this->request->query('date');

        if ($this->request->getRequestUri() == "/print-data-pengadaan-pdf?") {
            $pengadaans = DB::table('pengadaans')->where('no_pengadaan', $this->no_pengadaan)->first();

            return view('petugas.layout.laporan.laporan-pengadaan-excel', [
                'pengadaan' => pengadaan::all(),
                'pengadaan_detail' => $pengadaan_detail,
                'pengadaans' => $pengadaans->no_pengadaan
            ]);
        } else {
            if ($this->request->input('date') == null) {
                $pengadaans = DB::table('pengadaans')->where('no_pengadaan', $this->no_pengadaan)->first();

                return view('petugas.layout.laporan.laporan-pengadaan-excel', [
                    'pengadaan' => pengadaan::all(),
                    'pengadaan_detail' => $pengadaan_detail,
                    'pengadaans' => $pengadaans->no_pengadaan
                ]);
            } else {

                $date = $this->request->input('date');

                $dateArray = explode('~', $date);

                $tanggalPertama = $dateArray[0] ?? null;
                $tanggalKedua = $dateArray[1] ?? null;

                $query = pengadaan::query();

                if ($tanggalPertama && $tanggalKedua) {
                    $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                } elseif ($tanggalPertama) {
                    $query->where('created_at', '>=', $tanggalPertama);
                } elseif ($tanggalKedua) {
                    $query->where('created_at', '<=', $tanggalKedua);
                }
                $pengadaan = $query->get();



                $pengadaans = DB::table('pengadaans')->where('no_pengadaan', $this->no_pengadaan)->first();

                return view('petugas.layout.laporan.laporan-pengadaan-excel', [
                    'pengadaan' => pengadaan::all(),
                    'pengadaan_detail' => $pengadaan_detail,
                    'pengadaans' => $pengadaans->no_pengadaan
                ]);
            }
        }
    }

    public function title(): string
    {
        // Ambil nama ruangan dari database
        $pengadaan = DB::table('pengadaans')->where('no_pengadaan', $this->no_pengadaan)->first();
        return $pengadaan->no_pengadaan;
    }
}
