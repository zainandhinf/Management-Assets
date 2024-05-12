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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SUController extends Controller
{
    // route view
    public function index()
    {
        return view(
            'super_user.layout.dashboard',
            [
                "title" => "Dashboard",
                "active" => "z"
            ]
        );
    }

    public function goPetugas()
    {
        return view('super_user.layout.petugas')->with([
            'title' => 'Data Petugas',
            'active' => 'z',
            'petugass' => User::all(),

        ]);
    }

    public function goPegawai()
    {
        return view('super_user.layout.pegawai')->with([
            'title' => 'Data Pegawai',
            'active' => 'z',
            'pegawais' => pegawai::all(),

        ]);
    }
    public function goBarang()
    {
        // $barangAll = barang::all();


        $cekKategori = DB::table('kategori_barangs')->count();

        $kategoris = kategori_barang::all();


        $kategori_barang = barang::join('kategori_barangs', 'kategori_barangs.id', '=', 'barangs.id_kategori')
            ->select('barangs.*', 'kategori_barangs.nama_kategori')
            ->get();

        // dd($kategori_barang);

        return view('super_user.layout.barang')->with([
            'title' => 'Data Barang',
            'active' => 'z',
            'cek' => $cekKategori,
            'barangs' => $kategori_barang,
            'kategoris' => $kategoris,
            // 'kategori_barang' => $kategori_barang,

        ]);
    }
    public function goKBarang()
    {
        return view('super_user.layout.kategoribrg')->with([
            'title' => 'Data Kategori Barang',
            'active' => 'z',
            'ktgr_brngs' => kategori_barang::all(),
        ]);
    }
    public function goRuangan()
    {
        $cekTipe = DB::table('tipe_ruangans')->count();

        return view('super_user.layout.ruangan')->with([
            'title' => 'Data Ruangan',
            'active' => 'z',
            'cek' => $cekTipe,
            'ruangans' => ruangan::all(),

        ]);
    }
    public function goTRuangan()
    {
        return view('super_user.layout.tiperuangan')->with([
            'title' => 'Data Tipe Ruangan',
            'active' => 'z',
            'tipe_ruangans' => tipe_ruangan::all(),

        ]);
    }
    public function goProfile()
    {
        return view('super_user.layout.profile')->with([
            'title' => 'Profile',
            'active' => 'z',

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
            'keterangan' => 'required|max:255'
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
            'no_telepon' => 'nullable|max:12',
            'username' => 'required|max:255',
            'password' => 'required|max:8',
            'role' => 'required',
        ]);

        $validateData['password'] = Hash::make($request->input('password'));



        User::create($validatedData);

        $request->session()->flash('success', 'Petugas baru telah ditambahkan!');

        return redirect('/petugas');
    }
    public function editPetugas(Request $request, User $user)
    {
        // dd($request);
        $validatedData = $request->validate([
            'nik' => 'max:16',
            'nama_user' => 'max:255',
            'jenis_kelamin' => 'max:10',
            'alamat' => 'nullable|max:255',
            'no_telepon' => 'nullable|max:13',
            'username' => 'max:255',
            'role' => 'max:12',
        ]);

        // dd($validatedData);

        DB::table('users')
            ->where('id', $request->input('id_user'))
            ->update($validatedData);

        $request->session()->flash('success', 'Petugas telah berhasil diedit!');

        return redirect('/petugas');
    }
    public function deletePetugas(Request $request, kategori_barang $kategori_barangs)
    {
        $nama_petugas = DB::table('users')
            ->select('nama_user')
            ->where('id', '=', $request->input('id_user'))
            ->get();

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
            'alamat' => 'nullable|max:255',
            'no_telepon' => 'nullable|max:12',
            'foto' => 'nullable',
        ]);


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
            'foto' => 'nullable',
        ]);

        // dd($validatedData);

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

        DB::table('pegawais')->where('id', $request->input('id_user'))->delete();

        $pesanFlash = "pegawai (Nama pegawai: *{$nama_pegawai[0]->nama_user} ) telah berhasil dihapus!";

        $request->session()->flash('success', $pesanFlash);

        return redirect('/pegawai');
    }
    // end end pegawai

    //barang

    public function addBarang(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'no_barang' => 'required|max:30',
            'kode_aktiva' => 'required|max:30',
            'nama_barang' => 'required|max:60',
            'id_kategori' => 'required',
            'qty' => 'required',
        ]);
        // dd($validatedData);




        barang::create($validatedData);

        $request->session()->flash('success', 'Barang baru telah ditambahkan!');

        return redirect('/barang');
    }

    public function editBarang(Request $request, pegawai $pegawai)
    {
        // dd($request);
        $validatedData = $request->validate([
            'no_barang' => 'required|max:30',
            'kode_aktiva' => 'required|max:30',
            'nama_barang' => 'required|max:60',
            'id_kategori' => 'required',
            'qty' => 'required',
        ]);

        // dd($validatedData);

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
            'no_ruangan' => 'required|max:16',
            'ruangan' => 'required|max:255',
            'lokasi' => 'required',
            'kapasitas' => 'required|numeric',
            'tipe_ruangan' => 'required',
        ]);

        $last_id = DB::table('ruangans')
            ->select('id')
            ->orderByDesc('id')
            ->get();

        if ($last_id->isEmpty()) {
            $last_id = 1;
        } else {
            $last_id = $last_id->first()->id + 1;
        }

        foreach ($request->file('foto') as $file) {
            $fileLocation = $file->store('fotoruangan');

            image_ruangan::create([
                'image' => $fileLocation,
                'id_ruangan' => $last_id
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
            ->select('id')
            ->where('id_ruangan', '=', $request->input('id_ruangan'))
            ->get();

        foreach ($images as $image) {
            Storage::delete($image->image);
        }

        DB::table('ruangans')->where('id', $request->input('id_ruangan'))->delete();
        DB::table('image_ruangans')->where('id_ruangan', $request->input('id_ruangan'))->delete();

        $pesanFlash = "Ruangan (Nama Ruangan: *{$nama_ruangan[0]->ruangan} ) telah berhasil dihapus!";

        $request->session()->flash('error', $pesanFlash);

        return redirect('/ruangan');
    }
    public function addimgRuangan(Request $request, image_ruangan $iamge_ruangan)
    {
        foreach ($request->file('foto') as $file) {
            $fileLocation = $file->store('fotoruangan');

            image_ruangan::create([
                'image' => $fileLocation,
                'id_ruangan' => $request->input('id_ruangan')
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

    //end crud
}
