<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Pengembalian; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengembalianController extends Controller
{
    public function index()
{
    $peminjaman = Peminjaman::with('pengembalian')
        ->where('status', 'diambil')
        ->orWhere('status', 'kembali')->latest()
        ->get();

    return view('petugas.pengembalian.index', compact('peminjaman'));
}

    public function verifyPengembalian(Request $request)
{
    // 1. Validasi Input
    $request->validate([
        'id_peminjaman' => 'required',
        'kode_barang'   => 'required', // Hasil scan QR
        'kondisi'       => 'required|in:baik,rusak', // Berdasarkan flowchart
    ]);

    // 2. Cari Detail Peminjaman yang statusnya 'diambil' (sedang dipinjam)
    $detail = DetailPeminjaman::with(['alat', 'peminjaman'])
        ->where('id_peminjaman', $request->id_peminjaman)
        ->whereHas('alat', function ($q) use ($request) {
            $q->where('kode_barang', $request->kode_barang);
        })
        ->where('status_pengambilan', 'diambil') 
        ->first();

    if (!$detail) {
        return back()->with('error', 'Data peminjaman barang tidak ditemukan atau sudah dikembalikan.');
    }

    return DB::transaction(function () use ($detail, $request) {
        
        // 3. Update Status di Tabel Detail
        $detail->update([
            'status_pengambilan' => 'kembali',
            'tanggal_kembali'    => now(),
            'kondisi_barang'     => $request->kondisi // Simpan catatan kondisi saat kembali
        ]);

        // 4. Update Stok Alat (Hanya jika kondisi BAIK, stok bertambah lagi)
        // Berdasarkan flowchart: Jika rusak, biasanya stok tidak langsung bertambah (perlu perbaikan)
        if ($request->kondisi == 'baik') {
            $detail->alat->increment('stok', $detail->jumlah);
        }

        // 5. Cek apakah SEMUA barang dalam transaksi ini sudah kembali
        $peminjaman = $detail->peminjaman;
        $masihAdaBarangDipinjam = $peminjaman->detail()
            ->where('status_pengambilan', 'diambil')
            ->exists();

        // 6. Jika tidak ada lagi barang yang dipinjam (semua sudah berstatus 'kembali')
        if (!$masihAdaBarangDipinjam) {
            
            // Cek apakah ada barang yang rusak dalam rombongan peminjaman ini
            $adaKerusakan = $peminjaman->detail()->where('kondisi_barang', 'rusak')->exists();
            
            $peminjaman->update([
                'status' => 'selesai',
                'tanggal_pengembalian_sebenarnya' => now(),
                // Opsional: tandai jika ada masalah/kerusakan pada peminjaman ini
                'keterangan' => $adaKerusakan ? 'Selesai dengan kerusakan' : 'Selesai tanpa kendala'
            ]);
        }
        

        return back()->with('success', 'Barang berhasil dikembalikan dalam kondisi ' . $request->kondisi);
    });
}
   
}