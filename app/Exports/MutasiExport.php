<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Http\Request;


class MutasiExport implements WithMultipleSheets
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
        $mutasiList = DB::table('mutasis')->get();

        // Buat sheet untuk setiap ruangan
        foreach ($mutasiList as $mutasi) {
            $sheets[] = new MutasiPerSheetExport($mutasi->no_mutasi, $this->request);
        }

        return $sheets;
    }
}
