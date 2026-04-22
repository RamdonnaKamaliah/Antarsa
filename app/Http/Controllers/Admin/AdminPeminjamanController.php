<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjamans;
use Illuminate\Http\Request;


class AdminPeminjamanController extends Controller
{
    public function index(){

        $stats = [
    'total_peminjaman' => Peminjamans::count(),
    'total_barangKembali' => Peminjamans::where('status', 'kembali')->count(),
    'total_barangPending' => Peminjamans::where('status', 'pending')->count(),
    'total_barangDitolak' => Peminjamans::where('status', 'ditolak')->count(),
];

    $batasWaktu = \Carbon\Carbon::now()->subDay();
    Peminjamans::where('status', 'pending')->where('created_at', '<=', $batasWaktu)
        ->update([
            'status' => 'expired',
            'alasan_penolakan' => 'Sistem: Dibatalkan otomatis karena tidak dikonfirmasi dalam 1x24 jam.'
        ]);
    
       $peminjaman = Peminjamans::with(['user', 'buku'])->latest()->get();
        return view('admin.Peminjaman.index', compact('peminjaman', 'stats'));
    }

    public function approve($id){
        $Peminjaman = Peminjamans::findOrFail($id);

        $buku = Buku::find($Peminjaman->buku_id);

        if($buku->stok <= 0){
            return back()->with('error', 'Gagal approve, stok sudah habis!');
        }
        
        $Peminjaman->status = 'disetujui';
        $Peminjaman->tgl_pinjam = now();

        $Peminjaman->save();

        $buku->stok = $buku->stok - 1; 
        $buku->save();

        return back()->with('success', 'Peminjaman berhasil disetujui');
        
    } 

    public function kembali($id){
        $peminjaman = Peminjamans::findOrFail($id);
        
        if($peminjaman-> status !== 'disetujui'){
            return back()->with('error', 'Data tidak valid untuk dikembalikan');
        }
        
        $peminjaman->status = 'kembali';
        $peminjaman->tgl_kembali_sebenarnya = now();
        $peminjaman->save();

        $buku = Buku::find($peminjaman->buku_id);
        if($buku){
            $buku->stok = $buku->stok + 1;
            $buku->save();
        }
        return back()->with('success', 'Alat berhasil dikembalikan dan stok telah bertambah!');
    }

    public function reject(Request $request, $id)
{
    $peminjaman = Peminjamans::findOrFail($id);

    // Update status dan simpan alasan dari input prompt tadi
    $peminjaman->status = 'ditolak';
    $peminjaman->alasan_penolakan = $request->alasan_penolakan;
    $peminjaman->save();

    return back()->with('success', 'Peminjaman berhasil ditolak.');
}

    public function show(String $id) {
        $peminjaman = Peminjamans::findOrFail($id);
        return view ('admin.peminjaman.show', compact('peminjaman'));
    }
}