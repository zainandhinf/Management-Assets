<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Http\Request;
use App\Models\penempatan;

class PenempatanPerSheetExport implements FromView, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $no_penempatan;
    protected $request;

    public function __construct($no_penempatan, Request $request)
    {
        $this->no_penempatan = $no_penempatan;
        $this->request = $request;
    }

    public function view(): View
    {
        $penempatan_detail = DB::table('penempatans')
            ->where('no_penempatan', '=', $this->no_penempatan)
            ->first();
        // Ambil data barang berdasarkan ruangan
        // $barang = DB::table('detail_barangs')
        // ->
        //     ->where('ruangan_id', $this->ruanganId)
        //     ->get();
        $date = $this->request->query('date');

        if ($this->request->getRequestUri() == "/print-data-penempatan-pdf?") {
            $penempatans = DB::table('penempatans')->where('no_penempatan', $this->no_penempatan)->first();

            return view('petugas.layout.laporan.laporan-penempatan-excel', [
                'penempatan' => penempatan::all(),
                'penempatan_detail' => $penempatan_detail,
                'penempatans' => $penempatans->no_penempatan
            ]);
        } else {
            if ($this->request->query('no_penempatan')) {
                $penempatan = penempatan::select('*')
                    ->where('no_penempatan', '=', $this->request->query('no_penempatan'))
                    ->get();
                $penempatans = DB::table('penempatans')->where('no_penempatan', $this->no_penempatan)->first();

                return view('petugas.layout.laporan.laporan-penempatan-excel', [
                    'penempatan' => $penempatan,
                    'penempatan_detail' => $penempatan_detail,
                    'penempatans' => $penempatans->no_penempatan
                ]);
            } else {
                if ($this->request->input('date') == null) {
                    $penempatans = DB::table('penempatans')->where('no_penempatan', $this->no_penempatan)->first();

                    return view('petugas.layout.laporan.laporan-penempatan-excel', [
                        'penempatan' => penempatan::all(),
                        'penempatan_detail' => $penempatan_detail,
                        'penempatans' => $penempatans->no_penempatan
                    ]);
                } else {

                    $date = $this->request->input('date');

                    $dateArray = explode('~', $date);

                    $tanggalPertama = $dateArray[0] ?? null;
                    $tanggalKedua = $dateArray[1] ?? null;

                    $query = penempatan::query();

                    if ($tanggalPertama && $tanggalKedua) {
                        $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                    } elseif ($tanggalPertama) {
                        $query->where('created_at', '>=', $tanggalPertama);
                    } elseif ($tanggalKedua) {
                        $query->where('created_at', '<=', $tanggalKedua);
                    }

                    $penempatan = $query->get();

                    $penempatans = DB::table('penempatans')->where('no_penempatan', $this->no_penempatan)->first();

                    return view('petugas.layout.laporan.laporan-penempatan-excel', [
                        'penempatan' => $penempatan,
                        'penempatan_detail' => $penempatan_detail,
                        'penempatans' => $penempatans->no_penempatan
                    ]);
                }

            }

        }

    }

    public function title(): string
    {
        // Ambil nama ruangan dari database
        $penempatan = DB::table('penempatans')->where('no_penempatan', $this->no_penempatan)->first();
        return $penempatan->no_penempatan;
    }
}
