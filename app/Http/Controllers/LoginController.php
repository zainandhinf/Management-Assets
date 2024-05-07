<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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



                // $request->session()->regenerate();


                Alert::toast('Login Success!','success');

                return redirect()->intended('/dashboard');

            } else{





                // $request->session()->regenerate();
                return redirect()->intended('/welcome');
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

}
