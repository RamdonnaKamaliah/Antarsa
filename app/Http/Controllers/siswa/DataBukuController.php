<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Buku;
use Illuminate\Http\Request;

class DataBukuController extends Controller
{
    public function index() {
        $alat = Buku::where('stok', '>', 0)->get();
        return view('peminjam.daftarAlat.index', compact('alat'));
    }

    public function show($id) {
        $alat = Buku::where('id', $id)->firstOrFail();
        return view('peminjam.daftarAlat.show', compact('alat'));
    }
}