<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Http\Request;
use App\Models\ruangan;

class RuanganPerSheetExport implements FromView, WithTitle
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
        $date = $this->request->query('date');
        $tipe = $this->request->query('tipe');
        if ($this->request->getRequestUri() == "/print-data-ruangan-pdf?") {
            $ruangan = ruangan::join('tipe_ruangans', 'tipe_ruangans.id', '=', 'ruangans.tipe_ruangan')
                ->select('ruangans.*', 'tipe_ruangans.nama_tipe')
                ->get();
            $ruangans = DB::table('ruangan')->where('no_ruangan', $this->noruangan)->first();

            return view('petugas.layout.laporan.laporan-ruangan-excel', [
                'ruangan' => $ruangan,
                'ruangans' => $ruangans->ruangan
            ]);
        } else {
            if ($this->request->query('no_ruangan')) {
                $ruangan = ruangan::join('tipe_ruangans', 'tipe_ruangans.id', '=', 'ruangans.tipe_ruangan')
                    ->select('ruangans.*', 'tipe_ruangans.nama_tipe')
                    ->where('no_ruangan', '=', $this->request->query('no_ruangan'))
                    ->get();
                $ruangans = DB::table('ruangan')->where('no_ruangan', $this->noruangan)->first();

                return view('petugas.layout.laporan.laporan-ruangan-excel', [
                    'ruangan' => $ruangan,
                    'ruangans' => $ruangans->ruangan
                ]);
            } else {
                if ($this->request->input('date') == null && $this->request->input('tipe') == null) {
                    $ruangan = ruangan::join('tipe_ruangans', 'tipe_ruangans.id', '=', 'ruangans.tipe_ruangan')
                        ->select('ruangans.*', 'tipe_ruangans.nama_tipe')
                        ->get();
                    $ruangans = DB::table('ruangan')->where('no_ruangan', $this->noruangan)->first();

                    return view('petugas.layout.laporan.laporan-ruangan-excel', [
                        'ruangan' => $ruangan,
                        'ruangans' => $ruangans->ruangan
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
                    $ruangans = DB::table('ruangan')->where('no_ruangan', $this->noruangan)->first();

                    return view('petugas.layout.laporan.laporan-ruangan-excel', [
                        'ruangan' => $ruangan,
                        'ruangans' => $ruangans->ruangan
                    ]);
                }
            }
        }
    }

    public function title(): string
    {
        // Ambil nama ruangan dari database
        $ruangan = DB::table('ruangans')->where('no_ruangan', $this->noruangan)->first();
        return $ruangan->ruangan;
    }
}
