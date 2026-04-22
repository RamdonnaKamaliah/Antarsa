<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;


class SiswaProfileController extends Controller
{
    public function index() {
        
        return view('peminjam.profile.index');
        
    }
}