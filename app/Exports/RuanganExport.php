<?php

namespace App\Exports;

use App\Models\ruangan;
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

class RuanganExport implements FromView, ShouldAutoSize
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
        $tipe = $this->request->query('tipe');
        if ($this->request->getRequestUri() == "/print-data-ruangan-pdf?") {
            $ruangan = ruangan::join('tipe_ruangans', 'tipe_ruangans.id', '=', 'ruangans.tipe_ruangan')
                ->select('ruangans.*', 'tipe_ruangans.nama_tipe')
                ->get();

            return view('petugas.layout.laporan.laporan-ruangan-excel', [
                'ruangans' => $ruangan,
            ]);
        } else {
            if ($this->request->query('no_ruangan')) {
                $ruangan = ruangan::join('tipe_ruangans', 'tipe_ruangans.id', '=', 'ruangans.tipe_ruangan')
                    ->select('ruangans.*', 'tipe_ruangans.nama_tipe')
                    ->where('no_ruangan', '=', $this->request->query('no_ruangan'))
                    ->get();

                return view('petugas.layout.laporan.laporan-ruangan-excel', [
                    'ruangans' => $ruangan,
                ]);
            } else {
                if ($this->request->input('date') == null && $this->request->input('tipe') == null) {
                    $ruangan = ruangan::join('tipe_ruangans', 'tipe_ruangans.id', '=', 'ruangans.tipe_ruangan')
                        ->select('ruangans.*', 'tipe_ruangans.nama_tipe')
                        ->get();

                    return view('petugas.layout.laporan.laporan-ruangan-excel', [
                        'ruangans' => $ruangan,
                    ]);
                } else {

                    $date = $this->request->input('date');
                    $tipe = $this->request->input('tipe');


                    if ($tipe) {
                        $ruangan = DB::table('ruangans')->where('tipe_ruangan', $tipe)->get();
                    } else {
                        $dateArray = explode('~', $date);

                        $tanggalPertama = $dateArray[0] ?? null;
                        $tanggalKedua = $dateArray[1] ?? null;

                        $query = ruangan::query();

                        if ($tanggalPertama && $tanggalKedua && $tipe) {
                            $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('tipe_ruangan', $tipe);
                        } else if ($tanggalPertama && $tanggalKedua) {
                            $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                        } elseif ($tanggalPertama && $tipe) {
                            $query->where('created_at', '>=', $tanggalPertama)->where('tipe_ruangan', $tipe);
                        } elseif ($tanggalPertama) {
                            $query->where('created_at', '>=', $tanggalPertama);
                        } elseif ($tanggalKedua && $tipe) {
                            $query->where('created_at', '<=', $tanggalKedua)->where('tipe_ruangan', $tipe);
                        } elseif ($tanggalKedua) {
                            $query->where('created_at', '<=', $tanggalKedua);
                        }

                        $ruangan = $query->get();
                    }

                    return view('petugas.layout.laporan.laporan-ruangan-excel', [
                        'ruangans' => $ruangan,
                    ]);
                }
            }
        }
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

