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

class PeminjamanPerSheetExport implements FromView, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $no_peminjaman;
    protected $request;

    public function __construct($no_peminjaman, Request $request)
    {
        $this->no_peminjaman = $no_peminjaman;
        $this->request = $request;
    }

    public function view(): View
    {
        $peminjaman_detail = DB::table('peminjamans')
            ->where('no_peminjaman', '=', $this->no_peminjaman)
            ->first();
        // Ambil data barang berdasarkan ruangan
        // $barang = DB::table('detail_barangs')
        // ->
        //     ->where('ruangan_id', $this->ruanganId)
        //     ->get();
        $date = $this->request->query('date');

        if ($this->request->getRequestUri() == "/print-data-peminjaman-pdf?") {
            $peminjaman = DB::table('peminjamans')
                ->select('*')
                ->get();
            $kode_barcode = null;
            $peminjamans = DB::table('peminjamans')->where('no_peminjaman', $this->no_peminjaman)->first();

            return view('petugas.layout.laporan.laporan-peminjaman-excel', [
                'peminjaman' => $peminjaman,
                'peminjaman_detail' => $peminjaman_detail,
                'peminjamans' => $peminjamans->no_peminjaman
            ]);
        } else {
            if ($this->request->query('no_peminjaman') || $this->request->query('kode_barcode')) {
                $peminjaman = DB::table('peminjamans')
                    ->select('*')
                    ->where('no_peminjaman', '=', $this->request->query('no_peminjaman'))
                    ->get();
                $kode_barcode = $this->request->query('kode_barcode');
                $peminjamans = DB::table('peminjamans')->where('no_peminjaman', $this->no_peminjaman)->first();

                return view('petugas.layout.laporan.laporan-peminjaman-excel', [
                    'peminjaman' => $peminjaman,
                    'peminjaman_detail' => $peminjaman_detail,
                    'peminjamans' => $peminjamans->no_peminjaman
                ]);
            } else {
                $kode_barcode = null;
                if ($this->request->input('date') == null) {
                    $peminjaman = DB::table('peminjamans')
                        ->select('*')
                        ->get();
                    $peminjamans = DB::table('peminjamans')->where('no_peminjaman', $this->no_peminjaman)->first();

                    return view('petugas.layout.laporan.laporan-peminjaman-excel', [
                        'peminjaman' => $peminjaman,
                        'peminjaman_detail' => $peminjaman_detail,
                        'peminjamans' => $peminjamans->no_peminjaman
                    ]);
                } else {

                    $date = $this->request->input('date');

                    $dateArray = explode('~', $date);

                    $tanggalPertama = $dateArray[0] ?? null;
                    $tanggalKedua = $dateArray[1] ?? null;

                    if ($tanggalPertama && $tanggalKedua) {
                        $query = DB::table('peminjamans')->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
                    } elseif ($tanggalPertama) {
                        $query = DB::table('peminjamans')->where('created_at', '>=', $tanggalPertama);
                    } elseif ($tanggalKedua) {
                        $query = DB::table('peminjamans')->where('created_at', '<=', $tanggalKedua);
                    }

                    $peminjaman = $query->get();



                    $peminjamans = DB::table('peminjamans')->where('no_peminjaman', $this->no_peminjaman)->first();

                    return view('petugas.layout.laporan.laporan-peminjaman-excel', [
                        'peminjaman' => $peminjaman,
                        'peminjaman_detail' => $peminjaman_detail,
                        'peminjamans' => $peminjamans->no_peminjaman
                    ]);
                }
            }

        }


    }

    public function title(): string
    {
        // Ambil nama ruangan dari database
        $peminjaman = DB::table('peminjamans')->where('no_peminjaman', $this->no_peminjaman)->first();
        return $peminjaman->no_peminjaman;
    }
}
