<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SUController extends Controller
{
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
}
