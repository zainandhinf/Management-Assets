<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Http\Request;

class AktivaPerRuanganSheetExport implements FromView, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $noruangan;
    protected $request;

    public function __construct($noruangan, Request $request)
    {
        $this->noruangan = $noruangan;
        $this->request = $request;
    }

    public function view(): View
    {
        // Ambil data barang berdasarkan ruangan
        // $barang = DB::table('detail_barangs')
        // ->
        //     ->where('ruangan_id', $this->ruanganId)
        //     ->get();

        $barang = DB::table('detail_penempatans')
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
            ->where('no_ruangan', $this->noruangan)
            // ->groupBy('no_ruangan')
            ->get();

        $ruangan = DB::table('ruangans')->where('no_ruangan', $this->noruangan)->first();

        return view('petugas.layout.laporan.laporan-aktiva-excel', [
            'assets' => $barang,
            'ruangans' => $ruangan->ruangan
        ]);
    }

    public function title(): string
    {
        // Ambil nama ruangan dari database
        $ruangan = DB::table('ruangans')->where('no_ruangan', $this->noruangan)->first();
        return $ruangan->ruangan;
    }
}
