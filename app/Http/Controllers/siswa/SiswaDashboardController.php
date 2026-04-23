<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjamans;

class SiswaDashboardController extends Controller
{
    public function index() {
    $userId = auth()->id();
    
    $stats = [
        'pinjaman_aktif' => Peminjamans::where('user_id', $userId)->where('status', 'disetujui')->count(),
        'total_pending' => Peminjamans::where('user_id', $userId)->where('status', 'pending')->count(),
        'total_kembali' => Peminjamans::where('user_id', $userId)->where('status', 'kembali')->count(),
    ];

    $pinjamanAktif = Peminjamans::where('user_id', $userId)
                        ->where('status', 'disetujui')
                        ->with('buku')
                        ->get();

    $rekomendasiBuku = Buku::with('kategori')
                        ->where('stok', '>', 0)
                        ->inRandomOrder()
                        ->take(4)
                        ->get();

    // Untuk alert deadline (3 hari sebelum)
    $pinjamanMendekatiDeadline = Peminjamans::where('user_id', $userId)
                                    ->where('status', 'disetujui')
                                    ->whereBetween('tgl_kembali_rencana', [now(), now()->addDays(3)])
                                    ->get();

    return view('peminjam.dashboard', compact('stats', 'pinjamanAktif', 'pinjamanMendekatiDeadline', 'rekomendasiBuku'));
}
}