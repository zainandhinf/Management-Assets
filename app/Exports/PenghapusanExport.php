<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Http\Request;


class PenghapusanExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Ambil data ruangan dari database
        $penghapusanList = DB::table('penghapusans')->get();

        // Buat sheet untuk setiap ruangan
        foreach ($penghapusanList as $penghapusan) {
            $sheets[] = new PenghapusanPerSheetExport($penghapusan->no_penghapusan, $this->request);
        }

        return $sheets;
    }
}
