<?php

namespace App\Exports;

use App\Models\pegawai;
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



// class PetugasExport implements FromCollection, WithHeadings
class PegawaiExport implements FromView, ShouldAutoSize
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
        // $query = User::query();

        // if ($this->request->has('date')) {
        //     $dates = explode('_', $this->request->get('date'));
        //     // $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', $dates[0])->startOfDay();
        //     $startDate = $dates[0];
        //     // $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', $dates[1])->endOfDay();
        //     $endDate = $dates[1];
        //     $query->whereBetween('created_at', [$startDate, $endDate]);
        // }

        // if ($this->request->has('role')) {
        //     $query->where('role', $this->request->get('role'));
        // }

        $date = $this->request->query('date');
        $departemen = $this->request->query('organisasi');
        $id_organisasi = DB::table('departemens')->where('no_departemen', $departemen)->first();

        // dd($id_organisasi);
        if ($departemen) {
            $pegawai = DB::table('pegawais')->where('id_departemen', $id_organisasi->id)->get();
        } else {
            $dateArray = explode('~', $date);

            $tanggalPertama = $dateArray[0] ?? null;
            $tanggalKedua = $dateArray[1] ?? null;

            // dd($dateArray);

            // // Validasi bahwa kedua tanggal ada
            // if ($tanggalPertama && $tanggalKedua) {
            //     // Query dengan whereBetween
            //     $petugas = User::whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->get();
            // } elseif ($tanggalPertama) {
            //     // Query jika hanya tanggal pertama yang ada
            //     $petugas = User::where('created_at', '>=', $tanggalPertama)->get();
            // } elseif ($tanggalKedua) {
            //     // Query jika hanya tanggal kedua yang ada
            //     $petugas = User::where('created_at', '<=', $tanggalKedua)->get();
            // } else {
            //     // Tidak ada tanggal, ambil semua data atau sesuai kebutuhan
            //     $petugas = User::all();
            // }

            $query = pegawai::query();

            if ($tanggalPertama && $tanggalKedua && $departemen) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('id_departemen', $id_organisasi->id);
            } else if ($tanggalPertama && $tanggalKedua) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua]);
            } elseif ($tanggalPertama && $departemen) {
                $query->where('created_at', '>=', $tanggalPertama)->where('id_departemen', $id_organisasi->id);
            } elseif ($tanggalPertama) {
                $query->where('created_at', '>=', $tanggalPertama);
            } elseif ($tanggalKedua && $departemen) {
                $query->where('created_at', '<=', $tanggalKedua)->where('id_departemen', $id_organisasi->id);
            } elseif ($tanggalKedua) {
                $query->where('created_at', '<=', $tanggalKedua);
            }
            // dd($query);

            // if ($role) {
            //     $query->where('role', $role);
            //     dd($query);
            // }

            $pegawai = $query->get();

            // $petugas = DB::table('users')
            // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
            // ->get();
        }
        // dd($petugas);

        // return $petugas;
        return view('petugas.layout.laporan.laporan-pegawai-excel', [
            'pegawais' => $pegawai
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
