<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index() {
        
        $stats = [
            'total_pengguna' => User::Count(),
            'total_alat'=> Alat::count(),
            'total_peminjaman' => Peminjaman::Count()
        ];
    
        return view('admin.dashboard', compact('stats'));
    }
}