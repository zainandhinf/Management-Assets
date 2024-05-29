<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\pegawai;
use App\Models\kategori_barang;
use App\Models\ruangan;
use App\Models\tipe_ruangan;
use App\Models\barang;
use App\Models\image_ruangan;
use App\Models\training;
use App\Models\detail_barang;
use App\Models\peserta_training;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Rules\SquareImage;

class SUController extends Controller
{
    // route view
    public function index()
    {
        return view(
            'super_user.layout.dashboard',
            [
                "title" => "Dashboard",
                "active" => "Dashboard"
            ]
        );
    }

    public function goPetugas()
    {
    $petugass = DB::table('users')
                    ->where('id',  '!=', auth()->user()->id)
                    ->get();

        return view('super_user.layout.petugas')->with([
            'title' => 'Data Petugas',
            'active' => 'Data Petugas',
            'petugass' => $petugass,

        ]);
    }

    public function goPegawai()
    {
        return view('super_user.layout.pegawai')->with([
            'title' => 'Data Pegawai',
            'active' => 'Data Pegawai',
            'pegawais' => pegawai::all(),

        ]);
    }
    public function goBarang()
    {
        // $barangAll = barang::all();


        $cekKategori = DB::table('kategori_barangs')->count();

        $kategoris = kategori_barang::all();

        $kode = barang::generateKode();

        $details = DB::table('detail_barangs')
                            ->join('barangs', 'barangs.no_barang', '=', 'detail_barangs.no_barang')
                            ->select('detail_barangs.*', 'barangs.nama_barang')
                            ->get();

        // dd($details);


        $kategori_barang = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();

        // dd($kategori_barang);

        return view('super_user.layout.barang')->with([
            'title' => 'Data Barang',
            'active' => 'Data Barang',
            'cek' => $cekKategori,
            'kode_barang' => $kode,
            'barangs' => $kategori_barang,
            'kategoris' => $kategoris,
            'details' => $details,
            // 'kategori_barang' => $kategori_barang,

        ]);
    }
    public function goKBarang()
    {
        return view('super_user.layout.kategoribrg')->with([
            'title' => 'Data Kategori Barang',
            'active' => 'Data Kategori Barang',
            'ktgr_brngs' => kategori_barang::all(),
        ]);
    }
    public function goRuangan()
    {
        $cekTipe = DB::table('tipe_ruangans')->count();

        return view('super_user.layout.ruangan')->with([
            'title' => 'Data Ruangan',
            'active' => 'Data Ruangan',
            'cek' => $cekTipe,
            'ruangans' => ruangan::all(),

        ]);
    }
    public function goTRuangan()
    {
        return view('super_user.layout.tiperuangan')->with([
            'title' => 'Data Tipe Ruangan',
            'active' => 'Data Tipe Ruangan',
            'tipe_ruangans' => tipe_ruangan::all(),

        ]);
    }
    public function goTraining()
    {
        $cek1 = DB::table('users')->where('role', '=', 'petugas')->count();
        $cek2 = DB::table('ruangans')->count();




                    // dd($total_peserta);

        return view('super_user.layout.training')->with([
            'title' => 'Data Training',
            'active' => 'Data Training',
            'trainings' => training::all(),
            // 'total_peserta' => $total_peserta,
            'cek1' => $cek1,
            'cek2' => $cek2,
        ]);
    }
    public function goPeserta()
    {
        $cek = DB::table('trainings')->count();

        $cek_pegawai = DB::table('pegawais')->count();

        $pesertas = DB::table('peserta_trainings')
            ->select('pegawais.foto', 'pegawais.nik', 'pegawais.nama_user', 'pegawais.jenis_kelamin', 'pegawais.no_telepon', 'pegawais.organisasi', 'peserta_trainings.id as id_peserta', 'trainings.nama_training', 'trainings.id as id_training')
            ->join('pegawais', 'pegawais.nik', '=', 'peserta_trainings.nik')
            ->join('trainings', 'trainings.id', '=', 'peserta_trainings.id_training')
            ->get();
        return view('super_user.layout.peserta')->with([
            'title' => 'Data Peserta Training',
            'active' => 'Data Peserta Training',
            'pesertas' => $pesertas,
            'cek' => $cek,
            'cek_pegawai' => $cek_pegawai,
        ]);
    }
    public function goProfile()
    {
        return view('super_user.layout.profile')->with([
            'title' => 'Profile',
            'active' => 'Profile',

        ]);
    }
    //end route view















    //crud





    //kategori barang
    public function addKategori(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|max:255'
        ]);

        kategori_barang::create($validatedData);

        $request->session()->flash('success', 'Kategori baru telah ditambahkan!');

        return redirect('/kategori-barang');
    }
    public function editKategori(Request $request, kategori_barang $kategori_barangs)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|max:255'
        ]);

        DB::table('kategori_barangs')
            ->where('id', $request->input('id_ktgr'))
            ->update($validatedData);

        $request->session()->flash('success', 'Kategori barang telah berhasil diedit!');

        return redirect('/kategori-barang');
    }
    public function deleteKategori(Request $request, kategori_barang $kategori_barangs)
    {
        $nama_kategori = DB::table('kategori_barangs')
            ->select('nama_kategori')
            ->where('id', '=', $request->input('id_ktgr'))
            ->get();

        DB::table('kategori_barangs')->where('id', $request->input('id_ktgr'))->delete();

        $pesanFlash = "Kategori barang (Nama Kategori: **{$nama_kategori[0]->nama_kategori}** ) telah berhasil dihapus!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/kategori-barang');
    }
    //





    //tipe ruangan
    public function addTipe(Request $request)
    {
        $validatedData = $request->validate([
            'nama_tipe' => 'required|max:255',
            'keterangan' => 'required|max:255'
        ]);

        tipe_ruangan::create($validatedData);

        $request->session()->flash('success', 'Tipe ruangan baru telah ditambahkan!');

        return redirect('/tipe-ruangan');
    }
    public function editTipe(Request $request, tipe_ruangan $tipe_ruangan)
    {
        $validatedData = $request->validate([
            'nama_tipe' => 'required|max:255',
            'keterangan' => 'required'
        ]);

        DB::table('tipe_ruangans')
            ->where('id', $request->input('id_tipe'))
            ->update($validatedData);

        $request->session()->flash('success', 'Tipe Ruangan telah berhasil diedit!');

        return redirect('/tipe-ruangan');
    }
    public function deleteTipe(Request $request, tipe_ruangan $tipe_ruangan)
    {
        $nama_tipe = DB::table('tipe_ruangans')
            ->select('nama_tipe')
            ->where('id', '=', $request->input('id_tipe'))
            ->get();

        DB::table('tipe_ruangans')->where('id', $request->input('id_tipe'))->delete();

        $pesanFlash = "Tipe ruangan (Nama Tipe: *{$nama_tipe[0]->nama_tipe} ) telah berhasil dihapus!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/tipe-ruangan');
    }
    //





    //petugas
    public function addPetugas(Request $request)
    {

        $validatedData = $request->validate([
            'nik' => 'required|max:16',
            'nama_user' => 'required|max:255',
            'jenis_kelamin' => 'required',
            'alamat' => 'nullable|max:255',
            'no_telepon' => 'nullable|max:16',
            'username' => 'required|max:255',
            'password' => 'required|max:64',
            'role' => 'required',
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);




        $validatedData['password'] = Hash::make($request->input('password'));


        if ($request->file('foto')) {

        $validatedData['foto'] = $request->file('foto')->store('fotopetugas');

        }

        User::create($validatedData);

        $request->session()->flash('success', 'Petugas baru telah ditambahkan!');

        return redirect('/petugas');
    }
    public function addPetugasFromPegawai(Request $request)
    {

        $validatedData = $request->validate([
            'nik' => 'required|max:16',
            'username' => 'required|max:255',
            'password' => 'required|max:64',
            'role' => 'required',
        ]);


        $datapegawai = DB::table('pegawais')
                                ->where('nik', '=', $request->nik)
                                ->select('*')
                                ->first();

        $validatedData['nama_user'] = $datapegawai->nama_user;
        $validatedData['jenis_kelamin'] = $datapegawai->jenis_kelamin;
        $validatedData['alamat'] = $datapegawai->alamat;
        $validatedData['no_telepon'] = $datapegawai->no_telepon;
        $validatedData['foto'] = $datapegawai->foto;
        $validatedData['password'] = Hash::make($request->input('password'));


        User::create($validatedData);

        $request->session()->flash('success', 'Petugas baru telah ditambahkan!');

        return redirect('/petugas');
    }
    public function editPetugas(Request $request, User $user)
    {
        // dd($request);
        $validatedData = $request->validate([
            'nik' => 'required|max:16',
            'nama_user' => 'required|max:255',
            'jenis_kelamin' => 'required',
            'alamat' => 'nullable|max:255',
            'no_telepon' => 'nullable|max:16',
            'username' => 'required|max:255',
            // 'password' => 'required|max:64',
            'role' => 'required',
        ]);

        // dd($validatedData);

        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('fotopetugas');

            if ($request->oldPic) {
                Storage::delete($request->oldPic);
            }
        }



        DB::table('users')
            ->where('id', $request->input('id_user'))
            ->update($validatedData);

        $request->session()->flash('success', 'Petugas telah berhasil diedit!');

        return redirect('/petugas');
    }
    public function deletePetugas(Request $request, User $user)
    {
        $nama_petugas = DB::table('users')
            ->select('nama_user')
            ->where('id', '=', $request->input('id_user'))
            ->get();

        if ($request->foto != null) {
            Storage::delete($request->input('foto'));
        }


        DB::table('users')->where('id', $request->input('id_user'))->delete();

        $pesanFlash = "Petugas (Nama Petugas: *{$nama_petugas[0]->nama_user} ) telah berhasil dihapus!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/petugas');
    }
    // end end petugas

    //pegawai
    public function addPegawai(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required|max:16',
            'nama_user' => 'required|max:255',
            'jenis_kelamin' => 'required',
            'no_telepon' => 'nullable|max:12',
            'alamat' => 'nullable|max:255',
            'organisasi' => 'required',
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ]);


        // dd($request);
        $validatedData['organisasi'] = strtoupper($request->input('organisasi'));


        if ($request->foto) {
            $validatedData['foto'] = $request->file('foto')->store('fotopegawai');
        } else {
            $validatedData['foto'] = '';

        }

        pegawai::create($validatedData);

        $request->session()->flash('success', 'Pegawai baru telah ditambahkan!');

        return redirect('/pegawai');
    }

    public function editPegawai(Request $request, pegawai $pegawai)
    {
        // dd($request);
        $validatedData = $request->validate([
            'nik' => 'max:16',
            'nama_user' => 'max:255',
            'jenis_kelamin' => 'max:10',
            'alamat' => 'nullable|max:255',
            'no_telepon' => 'nullable|max:13',
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        // dd($validatedData);
        if ($request->file('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('fotopetugas');

            if ($request->oldPic) {
                Storage::delete($request->oldPic);
            }
        }


        DB::table('pegawais')
            ->where('id', $request->input('id_user'))
            ->update($validatedData);

        $request->session()->flash('success', 'Pegawai telah berhasil diedit!');

        return redirect('/pegawai');
    }

    public function deletePegawai(Request $request)
    {
        $nama_pegawai = DB::table('pegawais')
            ->select('nama_user')
            ->where('id', '=', $request->input('id_user'))
            ->get();


            if ($request->foto != null) {

                Storage::delete($request->input('foto'));

            }


        DB::table('pegawais')->where('id', $request->input('id_user'))->delete();

        $pesanFlash = "pegawai (Nama pegawai: *{$nama_pegawai[0]->nama_user} ) telah berhasil dihapus!";

        $request->session()->flash('success', $pesanFlash);

        return redirect('/pegawai');
    }
    // end end pegawai

    //barang

    public function addBarang(Request $request)
{
    try {
        $validatedData = $request->validate([
            'no_barang' => 'required|max:30',
            'nama_barang' => 'required|unique:barangs,nama_barang|max:60',
            'kode_awal' => 'required|unique:barangs,kode_awal|max:5',
            'id_kategori' => 'required',
            'qty' => 'required',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Tambahkan pesan flash untuk kesalahan validasi
        $request->session()->flash('error', 'Barang baru GAGAL ditambahkan!, periksa validasi');
        return redirect('/barang')
                    ->withErrors($e->validator)
                    ->withInput();
    }

    // Jika validasi berhasil, tambahkan barang
    barang::create($validatedData);

    // Tambahkan pesan flash untuk kesuksesan
    $request->session()->flash('success', 'Barang baru telah ditambahkan!');

    return redirect('/barang');
}


    public function editBarang(Request $request, pegawai $pegawai)
    {
        try {
            $validatedData = $request->validate([
                'no_barang' => 'required|max:30',
                'nama_barang' => 'required|unique:barangs,nama_barang|max:60',
                'kode_awal' => 'required|unique:barangs,kode_awal|max:5',
                'id_kategori' => 'required',
                'qty' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tambahkan pesan flash untuk kesalahan validasi
            $request->session()->flash('error', 'Data GAGAL diubah, periksa validasi!');
            return redirect('/barang')
                        ->withErrors($e->validator)
                        ->withInput();
        }

        DB::table('barangs')
            ->where('id', $request->input('id_barang'))
            ->update($validatedData);

        $request->session()->flash('success', 'Barang telah berhasil diedit!');

        return redirect('/barang');
    }

    public function deleteBarang(Request $request)
    {
        $data = DB::table('barangs')
            ->select('nama_barang')
            ->where('id', '=', $request->input('id_barang'))
            ->get();



        DB::table('barangs')->where('id', $request->input('id_barang'))->delete();

        $pesanFlash = "Barang (Nama Barang: *{$data[0]->nama_barang} ) telah berhasil dihapus!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/barang');
    }


    //end end barang






    // profile
    public function editProfile(Request $request, User $user)
    {
        // $validatedData = $request->validate([
        //     'nik' => 'required|max:255',
        //     'nama_user' => 'required|max:255',
        //     'jenis_kelamin' => 'required',
        //     'alamat' => 'max:255',
        //     'no_telepon' => 'max:12',
        //     'username' => 'required|max:255|unique:users',
        // ]);

        DB::table('users')
            ->where('id', $request->input('id_user'))
            ->update([
                'nik' => $request->input('nik'),
                'nama_user' => $request->input('nama_user'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'alamat' => $request->input('alamat'),
                'no_telepon' => $request->input('no_telepon'),
                'username' => $request->input('username'),
            ]);
        // ddd($validatedData);

        // DB::table('users')
        //     ->where('id', $request->input('id_user'))
        //     ->update($validatedData);

        $request->session()->flash('success', 'Data user telah berhasil diedit!');

        return redirect('/profile');
    }
    public function editPassword(Request $request, User $user)
    {
        if ($request->new_password == $request->password) {
            DB::table('users')
                ->where('id', $request->input('id_user'))
                ->update([
                    'password' => Hash::make($request->input('password')),
                ]);

            $request->session()->flash('success', 'Password telah berhasil diubah!');

            return redirect('/profile');
        } else {
            $request->session()->flash('error', 'Konfirmasi password salah!');

            return redirect('/profile');
        }

    }
    public function editProfileImage(Request $request, User $user)
    {
        Storage::delete($request->oldPic);

        $foto_profil = $request->file('foto')->store('photoprofile');

        DB::table('users')
            ->where('id', auth()->user()->id)
            ->update([
                'foto' => $foto_profil
            ]);

        $request->session()->flash('success', 'Foto profil telah berhasil diubah!');

        return redirect('/profile');


        // if ($request->oldPic) {
        //     Storage::delete($request->oldPic);
        // }

    }
    //




    //ruangan
    public function addRuangan(Request $request)
    {
        // ddd($request);
        $validatedData = $request->validate([
            'no_ruangan' => 'required|max:16|unique:ruangans',
            'ruangan' => 'required|max:255',
            'lokasi' => 'required',
            'kapasitas' => 'required|numeric',
            'tipe_ruangan' => 'required',
        ]);

        // $last_id = DB::table('ruangans')
        //     ->select('id')
        //     ->orderByDesc('id')
        //     ->get();


        // if ($last_id->isEmpty()) {
        //     $last_id = 1;
        // } else {
        // $last_id = $last_id->first()->id + 1;
        // }

        foreach ($request->file('foto') as $file) {
            $fileLocation = $file->store('fotoruangan');

            image_ruangan::create([
                'image' => $fileLocation,
                'no_ruangan' => $request->input('no_ruangan')
            ]);
        }

        ruangan::create($validatedData);

        $request->session()->flash('success', 'Ruangan baru telah ditambahkan!');

        return redirect('/ruangan');
    }
    public function editRuangan(Request $request, ruangan $ruangan)
    {
        $validatedData = $request->validate([
            'no_ruangan' => 'required|max:16',
            'ruangan' => 'required|max:255',
            'lokasi' => 'required',
            'kapasitas' => 'required|numeric',
            'tipe_ruangan' => 'required',
        ]);


        DB::table('ruangans')
            ->where('id', $request->input('id_ruangan'))
            ->update($validatedData);


        $request->session()->flash('success', 'Ruangan telah berhasil diedit!');

        return redirect('/ruangan');
    }

    public function deleteRuangan(Request $request, ruangan $ruangan)
    {
        $nama_ruangan = DB::table('ruangans')
            ->select('ruangan')
            ->where('id', '=', $request->input('id_ruangan'))
            ->get();

        $images = DB::table('image_ruangans')
            ->select('*')
            ->where('no_ruangan', '=', $request->input('no_ruangan'))
            ->get();

        foreach ($images as $image) {
            Storage::delete($image->image);
        }


        DB::table('ruangans')->where('id', $request->input('id_ruangan'))->delete();
        DB::table('image_ruangans')->where('no_ruangan', $request->input('no_ruangan'))->delete();

        $pesanFlash = "Ruangan (Nama Ruangan: *{$nama_ruangan[0]->ruangan} ) telah berhasil dihapus!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/ruangan');
    }
    public function addimgRuangan(Request $request, image_ruangan $iamge_ruangan)
    {
        foreach ($request->file('foto') as $file) {
            $fileLocation = $file->store('fotoruangan');
            $noRuangan = $request->input('no_ruangan');

            image_ruangan::create([
                'image' => $fileLocation,
                'no_ruangan' => $noRuangan,
            ]);
        }

        $request->session()->flash('success', 'Foto ruangan telah berhasil ditambah!');

        return redirect('/ruangan');
    }
    public function deleteimgRuangan(Request $request, image_ruangan $image_ruangan)
    {
        Storage::delete($request->input('image'));

        DB::table('image_ruangans')->where('id', $request->input('id_image'))->delete();

        $request->session()->flash('error', 'Foto ruangan telah berhasil dihapus!');

        return redirect('/ruangan');
    }
    //



    //training
    public function addTraining(Request $request)
    {
        // WOrk tapi ga ngerti...

        $cek = DB::table('trainings')
            ->select('trainings.*', 'ruangans.ruangan')
            ->join('ruangans', 'ruangans.no_ruangan', '=', 'trainings.no_ruangan')
            ->where('trainings.no_ruangan', '=', $request->no_ruangan)
            ->where(function ($query) use ($request) {
                $query->where(function ($subquery) use ($request) {
                    $subquery->where('trainings.tanggal_mulai', '>=', $request->input('tanggal_mulai'))
                        ->where('trainings.tanggal_mulai', '<=', $request->input('tanggal_selesai'));
                })
                    ->orWhere(function ($subquery) use ($request) {
                        $subquery->where('trainings.tanggal_selesai', '>=', $request->input('tanggal_mulai'))
                            ->where('trainings.tanggal_selesai', '<=', $request->input('tanggal_selesai'));
                    })
                    ->orWhere(function ($subquery) use ($request) {
                        $subquery->where('trainings.tanggal_mulai', '<=', $request->input('tanggal_mulai'))
                            ->where('trainings.tanggal_selesai', '>=', $request->input('tanggal_selesai'));
                    });
            })
            ->where(function ($query) use ($request) {
                $query->where(function ($subquery) use ($request) {
                    $subquery->where('trainings.waktu_mulai', '>=', $request->input('waktu_mulai'))
                        ->where('trainings.waktu_mulai', '<=', $request->input('waktu_selesai'));
                })
                    ->orWhere(function ($subquery) use ($request) {
                        $subquery->where('trainings.waktu_selesai', '>=', $request->input('waktu_mulai'))
                            ->where('trainings.waktu_selesai', '<=', $request->input('waktu_selesai'));
                    })
                    ->orWhere(function ($subquery) use ($request) {
                        $subquery->where('trainings.waktu_mulai', '<=', $request->input('waktu_mulai'))
                            ->where('trainings.waktu_selesai', '>=', $request->input('waktu_selesai'));
                    });
            })
            ->get();



        // dd($cek);


        if ($cek->isEmpty()) {


            $validatedData = $request->validate([
                'nama_training' => '',
                'tanggal_mulai' => '',
                'tanggal_selesai' => 'nullable',
                'waktu_mulai' => '',
                'waktu_selesai' => '',
                'no_ruangan' => '',
                'total_peserta' => '',
                'instruktur' => '',
                'id_petugas' => '',
                'keterangan' => ''
            ]);


            $validatedData['total_peserta'] = 0;



            if ($request->tanggal_selesai) {
                $validatedData['tanggal_selesai'] = $request->input('tanggal_selesai');
            } else {
                $validatedData['tanggal_selesai'] = $request->input('tanggal_mulai');
            }

            // dd($validatedData);
            training::create($validatedData);

            $request->session()->flash('success', 'Training baru telah ditambahkan!');

            return redirect('/training');





        } else {
            $request->session()->flash('error', 'Ruangan Terpakai Pada Tanggal dan Jam Tersebut !');

            return redirect('/training');
        }

    }

    public function editInfoTraining(Request $request){

        $validatedData = $request->validate([
            'nama_training' => '',
            'tanggal_mulai' => '',
            'tanggal_selesai' => 'nullable',
            'waktu_mulai' => '',
            'waktu_selesai' => '',
            'no_ruangan' => '',
            'total_peserta' => '',
            'instruktur' => '',
            'id_petugas' => '',
            'keterangan' => ''
        ]);


        $validatedData['total_peserta'] = 0;



        if ($request->tanggal_selesai) {
            $validatedData['tanggal_selesai'] = $request->input('tanggal_selesai');
        } else {
            $validatedData['tanggal_selesai'] = $request->input('tanggal_mulai');
        }

        // dd($validatedData);
        DB::table('trainings')
            ->where('id', $request->input('id_training'))
            ->update($validatedData);

        $request->session()->flash('success', 'Informasi Training telah diedit!');

        return redirect('/training');


    }

    public function editTraining(Request $request, training $training)
    {
        $cek = DB::table('trainings')
            ->select('trainings.*', 'ruangans.ruangan')
            ->join('ruangans', 'ruangans.no_ruangan', '=', 'trainings.no_ruangan')
            ->where('trainings.no_ruangan', '=', $request->no_ruangan)
            ->where(function ($query) use ($request) {
                $query->where(function ($subquery) use ($request) {
                    $subquery->where('trainings.tanggal_mulai', '>=', $request->input('tanggal_mulai'))
                        ->where('trainings.tanggal_mulai', '<=', $request->input('tanggal_selesai'));
                })
                    ->orWhere(function ($subquery) use ($request) {
                        $subquery->where('trainings.tanggal_selesai', '>=', $request->input('tanggal_mulai'))
                            ->where('trainings.tanggal_selesai', '<=', $request->input('tanggal_selesai'));
                    })
                    ->orWhere(function ($subquery) use ($request) {
                        $subquery->where('trainings.tanggal_mulai', '<=', $request->input('tanggal_mulai'))
                            ->where('trainings.tanggal_selesai', '>=', $request->input('tanggal_selesai'));
                    });
            })
            ->where(function ($query) use ($request) {
                $query->where(function ($subquery) use ($request) {
                    $subquery->where('trainings.waktu_mulai', '>=', $request->input('waktu_mulai'))
                        ->where('trainings.waktu_mulai', '<=', $request->input('waktu_selesai'));
                })
                    ->orWhere(function ($subquery) use ($request) {
                        $subquery->where('trainings.waktu_selesai', '>=', $request->input('waktu_mulai'))
                            ->where('trainings.waktu_selesai', '<=', $request->input('waktu_selesai'));
                    })
                    ->orWhere(function ($subquery) use ($request) {
                        $subquery->where('trainings.waktu_mulai', '<=', $request->input('waktu_mulai'))
                            ->where('trainings.waktu_selesai', '>=', $request->input('waktu_selesai'));
                    });
            })
            ->get();



        // dd($cek);


        if ($cek->isEmpty()) {


            $validatedData = $request->validate([
                'nama_training' => '',
                'tanggal_mulai' => '',
                'tanggal_selesai' => 'nullable',
                'waktu_mulai' => '',
                'waktu_selesai' => '',
                'no_ruangan' => '',
                'total_peserta' => '',
                'instruktur' => '',
                'id_petugas' => '',
                'keterangan' => ''
            ]);


            $validatedData['total_peserta'] = 0;



            if ($request->tanggal_selesai) {
                $validatedData['tanggal_selesai'] = $request->input('tanggal_selesai');
            } else {
                $validatedData['tanggal_selesai'] = $request->input('tanggal_mulai');
            }

            // dd($validatedData);
            DB::table('trainings')
            ->where('id', $request->input('id_training'))
            ->update($validatedData);

            $request->session()->flash('success', 'Waktu Training BARU telah dibuat!');

            return redirect('/training');





        } else {
            $request->session()->flash('error', 'Ruangan Terpakai Pada Tanggal dan Jam Tersebut !');

            return redirect('/training');
        }



    }
    public function deleteTraining(Request $request, training $training)
    {
        $nama = DB::table('trainings')
            ->select('nama_training')
            ->where('id', '=', $request->input('id_training'))
            ->get();

        $data_peserta = DB::table('peserta_trainings')
                            ->where('id_training',  $request->input('id_training'))->delete();

        DB::table('trainings')->where('id', $request->input('id_training'))->delete();

        $pesanFlash = "Kategori barang (Nama Kategori: **{$nama[0]->nama_training}** ) telah berhasil dihapus!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/training');
    }
    //

    //peserta training
    public function addPeserta(Request $request)
    {
        $training = DB::table('trainings')->select('*')->where('id', '=', $request->input('id_training'))->get();
        $kapasitas = DB::table('ruangans')->select('*')->where('no_ruangan', '=', $training[0]->no_ruangan)->get();
        $jumlah_peserta_seluruh = DB::table('peserta_trainings')
            ->select('*')
            ->where('id_training', '=', $request->input('id_training'))
            ->count();


        $cekPeserta = DB::table('peserta_trainings')
            ->join('trainings', 'peserta_trainings.id_training', '=', 'trainings.id')
            ->where('peserta_trainings.nik', '=', $request->input('nik'))
            ->select('peserta_trainings.id')
            ->first();

        // dd($cekPeserta);

        if ($kapasitas[0]->kapasitas == $jumlah_peserta_seluruh) {
            $request->session()->flash('error', 'Data peserta baru gagal ditambahkan! Kapasitas ruangan sudah maksimal!');

            return redirect('/peserta-training');

        } else {
            // if ($cekPeserta->id == $request->input('id_training')) {
            if ($cekPeserta) {
                $request->session()->flash('error', 'Data peserta baru gagal ditambahkan! Pegawai sudah Sudah terdaftar di Training ini!');

                return redirect('/peserta-training');
            } else {
                $validatedData = $request->validate([
                    'nik' => 'required',
                    'id_training' => 'required',
                ]);

                // dd($validatedData);

                peserta_training::create($validatedData);

                $jumlah_peserta = DB::table('peserta_trainings')
                    ->select('*')
                    ->where('id_training', '=', $request->input('id_training'))
                    ->count();

                if ($jumlah_peserta == 0) {
                    DB::table('trainings')
                        ->where('id', $request->input('id_training'))
                        ->update([
                            'total_peserta' => 1,
                        ]);
                } else {
                    DB::table('trainings')
                        ->where('id', $request->input('id_training'))
                        ->update([
                            'total_peserta' => $jumlah_peserta,
                        ]);

                }

                $request->session()->flash('success', 'Data peserta baru telah ditambahkan!');

                return redirect('/peserta-training');
            }
        }

    }
    public function editPeserta(Request $request, peserta_training $peserta_training)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'jenis_kelamin' => 'required',
            'nbpt' => 'required|max:255',
            'tempat_lahir' => 'nullable|required',
            'tanggal_lahir' => 'nullable|required',
            'id_training' => 'required',
        ]);

        DB::table('peserta_trainings')
            ->where('id', $request->input('id_peserta'))
            ->update($validatedData);

        $request->session()->flash('success', 'Data Peserta telah berhasil diedit!');

        return redirect('/peserta-training');
    }
    public function deletePeserta(Request $request, peserta_training $peserta_training)
    {
        $nama_peserta = DB::table('peserta_trainings')
            ->select(
                'pegawais.foto',
                'pegawais.nik',
                'pegawais.nama_user',
                'pegawais.jenis_kelamin',
                'pegawais.no_telepon',
                'pegawais.organisasi',
                'peserta_trainings.id as id_peserta',
                'trainings.nama_training',
                'trainings.id as id_training',
            )
            ->join('pegawais', 'pegawais.nik', '=', 'peserta_trainings.nik')
            ->join('trainings', 'trainings.id', '=', 'peserta_trainings.id_training')
            ->where('peserta_trainings.id','=',$request->input('id_peserta'))
            ->get();

        DB::table('peserta_trainings')->where('id', $request->input('id_peserta'))->delete();

        $jumlah_peserta = DB::table('peserta_trainings')
            ->select('*')
            ->where('id_training', '=', $request->input('id_training'))
            ->count();

        DB::table('trainings')
            ->where('id', $request->input('id_training'))
            ->update([
                'total_peserta' => $jumlah_peserta,
            ]);


        $pesanFlash = "Data Peserta (Nama Peserta: *{$nama_peserta[0]->nama_user} ) telah berhasil dihapus!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/peserta-training');
    }

    public function getUserByNik(Request $request)
    {
        $nik = $request->input('nik');
        $user = pegawai::where('nik', $nik)->first();

        if ($user) {
            return response()->json(['status' => 'success', 'data' => $user]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
        }
    }
    // end end peserta training

    //end crud
}
