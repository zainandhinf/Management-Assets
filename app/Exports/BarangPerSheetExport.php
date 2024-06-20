<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Http\Request;
use App\Models\barang;

class BarangPerSheetExport implements FromView, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $nobarang;
    protected $request;

    public function __construct($nobarang, Request $request)
    {
        $this->nobarang = $nobarang;
        $this->request = $request;
    }

    public function view(): View
    {
        // Ambil data barang berdasarkan ruangan
        // $barang = DB::table('detail_barangs')
        // ->
        //     ->where('ruangan_id', $this->ruanganId)
        //     ->get();
        $date = $this->request->query('date');
        $kategori = $this->request->query('kategori');

        if ($date == null && $kategori == null) {
            // $barang = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            //     ->select('barangs.*', 'kategori_barangs.nama_kategori')
            //     ->get();
            $barang = DB::table('barangs')
                ->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                ->select('barangs.*', 'kategori_barangs.nama_kategori')
                ->get();
            $barangs = DB::table('barangs')->where('no_barang', $this->nobarang)->first();
            // dd($barang);

            return view('petugas.layout.laporan.laporan-barang-excel', [
                'barang' => $barang,
                'barangs' => $barangs->nama_barang
            ]);
        } else {

            // $date = $request->input('date');
            // $kategori = $request->input('kategori');


            if ($kategori) {
                $barang = DB::table('barangs')->where('id_kategori', $kategori)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                    ->select('barangs.*', 'kategori_barangs.nama_kategori')->get();
            } else {
                $dateArray = explode('~', $date);

                $tanggalPertama = $dateArray[0] ?? null;
                $tanggalKedua = $dateArray[1] ?? null;
                $query = barang::query();

                if ($tanggalPertama && $tanggalKedua && $kategori) {
                    $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('id_kategori', $kategori)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                } else if ($tanggalPertama && $tanggalKedua) {
                    $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                } elseif ($tanggalPertama && $kategori) {
                    $query->where('created_at', '>=', $tanggalPertama)->where('id_kategori', $kategori)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                } elseif ($tanggalPertama) {
                    $query->where('created_at', '>=', $tanggalPertama)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                } elseif ($tanggalKedua && $kategori) {
                    $query->where('created_at', '<=', $tanggalKedua)->where('id_kategori', $kategori)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                } elseif ($tanggalKedua) {
                    $query->where('created_at', '<=', $tanggalKedua)->join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
                        ->select('barangs.*', 'kategori_barangs.nama_kategori');
                }

                $barang = $query->get();
            }

            $barangs = DB::table('barangs')->where('no_barang', $this->nobarang)->first();


            return view('petugas.layout.laporan.laporan-barang-excel', [
                'barang' => $barang,
                'barangs' => $barangs->nama_barang
            ]);
        }
    }

    public function title(): string
    {
        // Ambil nama ruangan dari database
        $barang = DB::table('barangs')->where('no_barang', $this->nobarang)->first();
        return $barang->nama_barang;
    }
}
