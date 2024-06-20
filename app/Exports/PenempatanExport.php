<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Http\Request;


class PenempatanExport implements WithMultipleSheets
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
        $penempatanList = DB::table('penempatans')->get();

        // Buat sheet untuk setiap ruangan
        foreach ($penempatanList as $penempatan) {
            $sheets[] = new PenempatanPerSheetExport($penempatan->no_penempatan, $this->request);
        }

        return $sheets;
    }
}
