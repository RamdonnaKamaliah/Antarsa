<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;

class AdminPengembalianController extends Controller
{
    public function index(){

        $stats = [
        'total_pengembalian' => Pengembalian::count(),
        'total_catatan' => Pengembalian::distinct('catatan')->count(),
        'total_kondisiRusak' => Pengembalian::where('kondisi_kembali', 'rusak')->count(),
        'total_kondisiBaik' => Pengembalian::where('kondisi_kembali', 'baik')->count(),
        'total_kondisiBaik' => Pengembalian::where('kondisi_kembali', 'baik')->count(),
        'total_kondisiBaik' => Pengembalian::where('kondisi_kembali', 'baik')->count(),
    ];

        $pengembalian = Pengembalian::latest()->get();
        return view('admin.pengembalian.index', compact('pengembalian', 'stats'));
    }

    public function show(String $id){
        $pengembalian = Pengembalian::findOrFail($id);
        return view('admin.pengembalian.show', compact('pengembalian'));
    }
}