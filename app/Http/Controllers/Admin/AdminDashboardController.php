<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index() {
        
    
        return view('admin.dashboard');
    }
}