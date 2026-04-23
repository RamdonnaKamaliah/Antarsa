<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Peminjamans;
use Illuminate\Http\Request;

class PeminjamanBukuController extends Controller
{
    public function index() {
    $peminjaman = Peminjamans::where('user_id', auth()->id())
                    ->with('user')
                    ->latest()
                    ->get();

    return view('peminjam.peminjamanAlat.index', compact('peminjaman'));
}

    public function store(Request $request) {

    $userId = auth()->id();

    // Cek apakah siswa punya peminjaman yang telat (lewat tgl_kembali_rencana tapi belum dikembalikan)
    $adaTunggakan = Peminjamans::where('user_id', $userId)
    ->where('status', 'disetujui')
    // Pakai toDateString() supaya cuma bandingkan tanggal (Y-m-d) tanpa jam
    ->whereDate('tgl_kembali_rencana', '<', now()->toDateString()) 
    ->whereNull('tgl_kembali_sebenarnya')
    ->exists();

    if ($adaTunggakan) {
        return redirect()->back()->with('error', 'Kamu belum bisa pinjam lagi. Ada buku yang telat dikembalikan. Kembalikan dulu ya!');
    }
    
    $selectedIds = $request->input('alat_selected'); // Dari hidden input javascript
    $keranjang = session()->get('keranjang');

    if (!$selectedIds || !$keranjang) {
        return redirect()->back()->with('error', 'Pilih alatnya dulu ya!');
    }

    // 1. Ambil input dari form modal Donna
    $tglBooking = \Carbon\Carbon::parse($request->tanggal_booking);
    $tglKembaliUser = \Carbon\Carbon::parse($request->tanggal_kembali_rencana);
    
    // 2. Logika Sakti 7 Hari
    $maxDeadline = $tglBooking->copy()->addDays(7);
    
    // Jika user minta lebih dari 7 hari, sistem otomatis potong jadi 7 hari
    if ($tglKembaliUser->gt($maxDeadline)) {
    return redirect()->back()->with('error', 'Durasi maksimal 7 hari!');
}
$deadlineFinal = $tglKembaliUser;

    // 3. Simpan ke database sesuai nama kolom di phpMyAdmin
    foreach ($selectedIds as $id) {
        if (isset($keranjang[$id])) {
            Peminjamans::create([
                'user_id'                => auth()->id(),
                'buku_id'                => $id,
                'tgl_booking'            => $tglBooking, // Masuk ke tgl_booking
                'tgl_pinjam'             => null,        // Masih null karena belum diambil (approved)
                'tgl_kembali_rencana'    => $deadlineFinal, // Masuk ke tgl_kembali_rencana
                'status'                 => 'pending',
            ]);
            
            // Hapus dari keranjang setelah berhasil disimpan
            unset($keranjang[$id]);
        }
    }

    session()->put('keranjang', $keranjang);

    
    Aktivitas::simpanLog('TAMBAH', 'Peminjamans', 'Mengajukan Peminjamans baru');

    return redirect()->route('siswa.peminjamAlat')->with('success', 'Berhasil mengajukan pinjaman!');
        
    }

   public function show(String $id){
        
     $peminjaman = Peminjamans::with('user',)->findOrFail($id);
    return view('peminjam.peminjamanAlat.show', compact('peminjaman'));
    
    }
}