<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Peminjamans;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    $selectedIds = $request->input('alat_selected'); // Dari hidden input javascript
    $keranjang = session()->get('keranjang');

    if (!$selectedIds || !$keranjang) {
        return redirect()->back()->with('error', 'Pilih alatnya dulu ya!');
    }

    // 1. Ambil input dari form modal Donna
    $tglBooking = \Carbon\Carbon::parse($request->tgl_booking);
    $tglKembaliUser = \Carbon\Carbon::parse($request->tgl_kembali_rencana);
    
    // 2. Logika Sakti 7 Hari
    $maxDeadline = $tglBooking->copy()->addDays(7);
    
    // Jika user minta lebih dari 7 hari, sistem otomatis potong jadi 7 hari
    $deadlineFinal = $tglKembaliUser->gt($maxDeadline) ? $maxDeadline : $tglKembaliUser;

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