<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
                // alert()->success('Berhasil Login !', $word);

                return redirect()->intended('/welcome');

            } else{





                $request->session()->regenerate();
                return redirect()->intended('/welcome');
            }

        }else {

            return back()->with('Login Gagal', 'Periksa Kembali Username / Password !');

        }
    }
}
