<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Alert;

class LoginController extends Controller
{
    public function login() {
        return view('login');
    }

    public function loginrequest(Request $request) {

        $login = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);


        if(Auth::attempt($login)) {
            $user = Auth::user();

            if ($user->role === 'super_user') {



                $request->session()->regenerate();


                Alert::toast('Login Success!','success');

                return redirect()->intended('/dashboard');

            } else{


            


                $request->session()->regenerate();
                return redirect()->intended('/dashboard-koordinator');
            }

        }else {

            Alert::toast('Login Gagal!, Periksa Kembali Username atau Password!','error');

            return back()->with('Login Gagal', 'Periksa Kembali Username / Password !');


        }
    }

    public function logout(Request $request) {
        Auth::logout();

        request()->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function forgotPassword() {
        return view('forgot');
    }

    public function tryCheck(Request $request) {



        $nik = $request->nik;

        $user = DB::table('users')
                        ->where('nik', '=', $request->nik)
                        ->first();

                        // dd($user);
        if ($user != null) {
            $request->validate([
                'nik' => 'required|exists:users,nik',
            ]);
            Alert::toast('Pegawai Teridentifikasi!','info');

            return view('changepass')->with([
                'user' => $user,

            ]);
        } else {

            Alert::toast('Tidak Ditemukan! Coba Periksa Kembali Nik','error');

            return view('forgot');

        }



    }

    public function cpfc(Request $request) {
        // dd($request);
        $nik = $request->nik;
        $pass = Hash::make($request->input('password'));


        $a = DB::table('users')
                ->where('nik', '=', $nik)
                ->select('nik', 'id')
                ->first();


        $idString = $a->id;

        $user = User::find($idString);
        $user->password = $pass;
        $user->update();


        Alert::success('Password Changed!','successfully');
        return redirect('/');

    }


}
