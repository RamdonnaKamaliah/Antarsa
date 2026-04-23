<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjamans;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
{
    // Mengambil data untuk Card Atas
    $totalUser = User::where('role', 'siswa')->count();
    $totalAlat = Buku::count();
    $totalPeminjaman = Peminjamans::count();

    // Mengambil data untuk Row Kedua
    $totalKembali = Peminjamans::where('status', 'kembali')->count();
    // $barangRusak = Buku::where('kondisi', 'rusak')->count(); // Sesuaikan kolom di DB kamu
    $pinjamHariIni = \App\Models\Peminjamans::whereDate('created_at', now()->today())->count();

    // Hitung Persentase (Total dipinjam / Total stok)
    $totalStok = Buku::sum('stok');
    $sedangDipinjam = Peminjamans::where('status', 'disetujui')->count();
    $persentase = $totalStok > 0 ? round(($sedangDipinjam / $totalStok) * 100) : 0;

    // Data Grafik Mingguan (7 hari terakhir)
    $labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
$grafikPeminjaman = [];

foreach ([6, 5, 4, 3, 2, 1, 0] as $day) {
    $date = now()->subDays($day)->toDateString();
    // Hitung jumlah transaksi berdasarkan tanggal created_at
    $count = \App\Models\Peminjamans::whereDate('created_at', $date)->count();
    $grafikPeminjaman[] = $count;
}

    return view('admin.dashboard', compact(
        'totalUser', 'totalAlat', 'totalPeminjaman', 
        'totalKembali', 'pinjamHariIni', 
        'persentase', 'grafikPeminjaman', 'labels'
    ));
}
}