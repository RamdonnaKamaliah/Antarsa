<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianAlatController extends Controller
{
   public function index() {
    $peminjaman = Peminjaman::where('id_user', auth()->id())
                    ->where('status', 'kembali') 
                    ->with('user')
                    ->latest()
                    ->get();

    return view('peminjam.pengembalianAlat.index', compact('peminjaman'));
}

 public function show(String $id){
        
     $peminjaman = Peminjaman::with('user')->findOrFail($id);
    return view('peminjam.pengembalianAlat.show', compact('peminjaman'));
    
    }

}