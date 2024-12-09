<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index ()
    {
        return view('layouts.konten');
    }

    public function tentang()
    {
        return view('layouts.tentang');
    }

    public function bantuan()
    {
        return view('layouts.bantuan');
    }
    
}
