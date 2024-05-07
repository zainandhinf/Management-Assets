<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\kategori_barang;
use App\Models\tipe_ruangan;
use Illuminate\Support\Facades\Hash;

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
            'active' => 'z'

        ]);
    }

    public function goPegawai()
    {
        return view('super_user.layout.pegawai')->with([
            'title' => 'Data Pegawai',
            'active' => 'z'

        ]);
    }
    public function goBarang()
    {
        return view('super_user.layout.barang')->with([
            'title' => 'Data Barang',
            'active' => 'z'

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
        return view('super_user.layout.ruangan')->with([
            'title' => 'Data Ruangan',
            'active' => 'z'

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

        $request->session()->flash('success', $pesanFlash);

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

        $pesanFlash = "Tipe ruangan (Nama Tipe: **{$nama_tipe[0]->nama_tipe}** ) telah berhasil dihapus!";

        $request->session()->flash('success', $pesanFlash);

        return redirect('/tipe-ruangan');
    }
    //

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
    //

    //end crud
}
