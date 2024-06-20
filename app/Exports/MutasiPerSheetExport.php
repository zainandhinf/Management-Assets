<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Http\Request;
use App\Models\mutasi;

class MutasiPerSheetExport implements FromView, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $no_mutasi;
    protected $request;

    public function __construct($no_mutasi, Request $request)
    {
        $this->no_mutasi = $no_mutasi;
        $this->request = $request;
    }

    public function view(): View
    {
        $mutasi_detail = DB::table('mutasis')
            ->where('no_mutasi', '=', $this->no_mutasi)
            ->first();
        // Ambil data barang berdasarkan ruangan
        // $barang = DB::table('detail_barangs')
        // ->
        //     ->where('ruangan_id', $this->ruanganId)
        //     ->get();
        $date = $this->request->query('date');

        if ($this->request->getRequestUri() == "/print-data-mutasi-pdf?") {
            $mutasis = DB::table('mutasis')->where('no_mutasi', $this->no_mutasi)->first();

            return view('petugas.layout.laporan.laporan-mutasi-excel', [
                'mutasi' => mutasi::all(),
                'mutasi_detail' => $mutasi_detail,
                'mutasis' => $mutasis->no_mutasi
            ]);
        } else {
            if ($this->request->query('no_mutasi')) {
                $mutasi = mutasi::select('*')
                    ->where('no_mutasi', '=', $this->request->query('no_mutasi'))
                    ->get();
                $mutasis = DB::table('mutasis')->where('no_mutasi', $this->no_mutasi)->first();

                return view('petugas.layout.laporan.laporan-mutasi-excel', [
                    'mutasi' => $mutasi,
                    'mutasi_detail' => $mutasi_detail,
                    'mutasis' => $mutasis->no_mutasi
                ]);
            } else {
                if ($this->request->input('date') == null) {
                    $mutasis = DB::table('mutasis')->where('no_mutasi', $this->no_mutasi)->first();

                    return view('petugas.layout.laporan.laporan-mutasi-excel', [
                        'mutasi' => mutasi::all(),
                        'mutasi_detail' => $mutasi_detail,
                        'mutasis' => $mutasis->no_mutasi
                    ]);
                } else {

                    $date = $this->request->input('date');

                    $dateArray = explode('~', $date);

                    $tanggalPertama = $dateArray[0] ?? null;
                    $tanggalKedua = $dateArray[1] ?? null;

                    $query = mutasi::query();

                    if ($tanggalPertama && $tanggalKedua) {
                        $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                    } elseif ($tanggalPertama) {
                        $query->where('created_at', '>=', $tanggalPertama);
                    } elseif ($tanggalKedua) {
                        $query->where('created_at', '<=', $tanggalKedua);
                    }

                    $mutasi = $query->get();

                    $mutasis = DB::table('mutasis')->where('no_mutasi', $this->no_mutasi)->first();

                    return view('petugas.layout.laporan.laporan-mutasi-excel', [
                        'mutasi' => $mutasi,
                        'mutasi_detail' => $mutasi_detail,
                        'mutasis' => $mutasis->no_mutasi
                    ]);
                }
            }

        }

    }

    public function title(): string
    {
        // Ambil nama ruangan dari database
        $mutasi = DB::table('mutasis')->where('no_mutasi', $this->no_mutasi)->first();
        return $mutasi->no_mutasi;
    }
}
