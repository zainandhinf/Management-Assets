<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Http\Request;
use App\Models\penghapusan;

class PenghapusanPerSheetExport implements FromView, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $no_penghapusan;
    protected $request;

    public function __construct($no_penghapusan, Request $request)
    {
        $this->no_penghapusan = $no_penghapusan;
        $this->request = $request;
    }

    public function view(): View
    {
        $penghapusan_detail = DB::table('penghapusans')
            ->where('no_penghapusan', '=', $this->no_penghapusan)
            ->first();
        // Ambil data barang berdasarkan ruangan
        // $barang = DB::table('detail_barangs')
        // ->
        //     ->where('ruangan_id', $this->ruanganId)
        //     ->get();
        $date = $this->request->query('date');

        if ($this->request->getRequestUri() == "/print-data-penghapusan-pdf?") {
            $penghapusans = DB::table('penghapusans')->where('no_penghapusan', $this->no_penghapusan)->first();

            return view('petugas.layout.laporan.laporan-penghapusan-excel', [
                'penghapusan' => penghapusan::all(),
                'penghapusan_detail' => $penghapusan_detail,
                'penghapusans' => $penghapusans->no_penghapusan
            ]);
        } else {
            if ($this->request->query('no_penghapusan')) {
                $penghapusan = penghapusan::select('*')
                    ->where('no_penghapusan', '=', $this->request->query('no_penghapusan'))
                    ->get();
                $penghapusans = DB::table('penghapusans')->where('no_penghapusan', $this->no_penghapusan)->first();

                return view('petugas.layout.laporan.laporan-penghapusan-excel', [
                    'penghapusan' => $penghapusan,
                    'penghapusan_detail' => $penghapusan_detail,
                    'penghapusans' => $penghapusans->no_penghapusan
                ]);
            } else {
                if ($this->request->input('date') == null) {
                    $penghapusans = DB::table('penghapusans')->where('no_penghapusan', $this->no_penghapusan)->first();

                    return view('petugas.layout.laporan.laporan-penghapusan-excel', [
                        'penghapusan' => penghapusan::all(),
                        'penghapusan_detail' => $penghapusan_detail,
                        'penghapusans' => $penghapusans->no_penghapusan
                    ]);
                } else {

                    $date = $this->request->input('date');

                    $dateArray = explode('~', $date);

                    $tanggalPertama = $dateArray[0] ?? null;
                    $tanggalKedua = $dateArray[1] ?? null;

                    $query = penghapusan::query();

                    if ($tanggalPertama && $tanggalKedua) {
                        $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                    } elseif ($tanggalPertama) {
                        $query->where('created_at', '>=', $tanggalPertama);
                    } elseif ($tanggalKedua) {
                        $query->where('created_at', '<=', $tanggalKedua);
                    }

                    $penghapusan = $query->get();

                    $penghapusans = DB::table('penghapusans')->where('no_penghapusan', $this->no_penghapusan)->first();

                    return view('petugas.layout.laporan.laporan-penghapusan-excel', [
                        'penghapusan' => $penghapusan,
                        'penghapusan_detail' => $penghapusan_detail,
                        'penghapusans' => $penghapusans->no_penghapusan
                    ]);
                }
            }

        }

    }

    public function title(): string
    {
        // Ambil nama ruangan dari database
        $penghapusan = DB::table('penghapusans')->where('no_penghapusan', $this->no_penghapusan)->first();
        return $penghapusan->no_penghapusan;
    }
}
