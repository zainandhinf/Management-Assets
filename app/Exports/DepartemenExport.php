<?php

namespace App\Exports;

use App\Models\departemen;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class DepartemenExport implements FromView, ShouldAutoSize
{
       // /**
    //  * @return \Illuminate\Support\Collection
    //  */
    use Exportable;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function view(): View
    {
        $date = $this->request->query('date');

        $dateArray = explode('~', $date);

        $tanggalPertama = $dateArray[0] ?? null;
        $tanggalKedua = $dateArray[1] ?? null;

        $query = departemen::query();

        if ($tanggalPertama && $tanggalKedua) {
            $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
        } elseif ($tanggalPertama) {
            $query->where('created_at', '>=', $tanggalPertama);
        } elseif ($tanggalKedua) {
            $query->where('created_at', '<=', $tanggalKedua);
        }

        $departemen = $query->get();

        return view('petugas.layout.laporan.laporan-departemen-excel', [
            'departemens' => $departemen
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Get worksheet
                $sheet = $event->sheet;

                // Set borders for all cells
                $sheet->getDelegate()->getStyle('A1:I' . ($sheet->getDelegate()->getHighestRow()))
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            }
        ];
    }

    // public function headings(): array
    // {
    //     return [
    //         'nik',
    //         'nama_user',
    //         'jenis_kelamin',
    //         'alamat',
    //         'no_telepon',
    //         'username',
    //         'role'
    //     ];
    // }
}
