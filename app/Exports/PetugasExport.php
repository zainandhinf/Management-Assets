<?php

namespace App\Exports;

use App\Models\User;
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
class PetugasExport implements FromView, ShouldAutoSize
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

    public function view() : View
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

        $date = $this->request->has('date');
        $role = $this->request->has('role');

        if ($role == "koordinator" || $role == "super_user") {
            if ($role == "koordinator") {
                $petugas = DB::table('users')->where('role', 'petugas')->get();
            } else {
                $petugas = DB::table('users')->where('role', $role)->get();
            }
        } else {
            $dateArray = explode('~', $date);

            $tanggalPertama = $dateArray[0] ?? null;
            $tanggalKedua = $dateArray[1] ?? null;

            if ($role == "koordinator") {
                $role = "petugas";
            }

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

            $query = User::query();

            if ($tanggalPertama && $tanggalKedua && $role) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->where('role', $role)->select('nik, nama_user, jenis_kelamin, alamat, no_telepon, username, role');
            } else if ($tanggalPertama && $tanggalKedua) {
                $query->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])->select('nik, nama_user, jenis_kelamin, alamat, no_telepon, username, role');
            } elseif ($tanggalPertama && $role) {
                $query->where('created_at', '>=', $tanggalPertama)->where('role', $role)->select('nik, nama_user, jenis_kelamin, alamat, no_telepon, username, role');
            } elseif ($tanggalPertama) {
                $query->where('created_at', '>=', $tanggalPertama)->select('nik, nama_user, jenis_kelamin, alamat, no_telepon, username, role');
            } elseif ($tanggalKedua && $role) {
                $query->where('created_at', '<=', $tanggalKedua)->where('role', $role)->select('nik, nama_user, jenis_kelamin, alamat, no_telepon, username, role');
            } elseif ($tanggalKedua) {
                $query->where('created_at', '<=', $tanggalKedua)->select('nik, nama_user, jenis_kelamin, alamat, no_telepon, username, role');
            }
            // dd($query);

            // if ($role) {
            //     $query->where('role', $role);
            //     dd($query);
            // }

            $petugas = $query->get();

            // $petugas = DB::table('users')
            // ->whereBetween('created_at', [$tanggalPertama, $tanggalKedua])
            // ->get();
        }
        // dd($petugas);

        // return $petugas;
        return view('petugas.layout.laporan.laporan-petugas-excel',[
            'petugass' => $petugas
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
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
