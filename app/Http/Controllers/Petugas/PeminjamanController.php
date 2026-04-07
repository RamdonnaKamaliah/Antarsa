<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;


class PeminjamanController extends Controller
{
    public function index() {

        Peminjaman::where('status', 'pending')->where('created_at', '<=', now()->subDay())->update(['status' => 'expired']);
        $peminjaman = Peminjaman::with('user', 'detail.alat')->latest()->get();
        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    public function approve($id){
        $peminjaman = Peminjaman::findOrFail($id);
        
        $peminjaman->status = 'disetujui';
        $peminjaman->disetujui_oleh = $peminjaman->id_user;

        $peminjaman->save();

        return back()->with('success', 'Peminjaman disetujui & QR Code berhasil dibuat!');
        
    } 

    public function scan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        return view('petugas.peminjaman.scan', compact('peminjaman'));
    }



public function verifyScan(Request $request)
{
    // Handle upload file QR
    if ($request->hasFile('qr_file')) {
        $request->validate([
            'qr_file'       => 'required|image',
            'id_peminjaman' => 'required'
        ]);

        $file = $request->file('qr_file');
        $filename = 'qr_scan_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('app/temp'), $filename);
        $path = storage_path('app/temp/' . $filename);

        $qr = new \Zxing\QrReader($path);
        $kodeBarang = $qr->text();

        @unlink($path);

        if (!$kodeBarang) {
            return back()->with('error', 'QR tidak terbaca, coba foto yang lebih jelas');
        }

        $request->merge(['kode_barang' => $kodeBarang]);
    }

    // Validate
    $request->validate([
        'kode_barang'   => 'required',
        'id_peminjaman' => 'required'
    ]);

    // Cari detail peminjaman
    $detail = DetailPeminjaman::with(['alat', 'peminjaman'])
        ->where('id_peminjaman', $request->id_peminjaman)
        ->whereHas('alat', function ($q) use ($request) {
            $q->where('kode_barang', $request->kode_barang);
        })
        ->where('status_pengambilan', '!=', 'diambil')
        ->first();

    if (!$detail) { // ✅ fix: tadi kurang $
        return back()->with('error', 'Barang tidak ditemukan atau sudah diambil');
    }

    if ($detail->alat->stok < $detail->jumlah) {
        return back()->with('error', 'Stok tidak mencukupi');
    }

    // Update stok & status
    $detail->alat->decrement('stok', $detail->jumlah);
    $detail->update([
        'status_pengambilan' => 'diambil',
        'tanggal_pengambilan' => now()
    ]);
    
    // 2. Ambil instance model Peminjaman (tabel induk)
    $peminjaman = $detail->peminjaman; 

    // 3. Cek apakah SEMUA detail barang untuk peminjaman ini sudah 'diambil'
    // Kita cek apakah masih ada yang BELUM 'diambil'
    $masihAdaBarangBelumDiambil = $peminjaman->detail() // <--- Pastikan nama relasi di model Peminjaman adalah detail()
        ->where('status_pengambilan', '!=', 'diambil')
        ->exists();

    // 4. Jika SUDAH TIDAK ADA lagi barang yang belum diambil (artinya semua sudah diambil)
    if (!$masihAdaBarangBelumDiambil) {
        $peminjaman->update([
            'status' => 'diambil', // Mengubah 'disetujui' menjadi 'dipinjam'
            'tanggal_pengambilan_sebenarnya' => now() // Mengisi tanggal ambil di tabel induk
        ]);
    }
    return back()->with('success', 'Barang berhasil diverifikasi & diambil'); // ✅ fix typo 'succes'
}

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan
        ]);

        return back()->with('success', 'Peminjaman berhasil ditolak');
    }

    public function show(String $id){
        $peminjaman = Peminjaman::with('user', 'detail.alat')->findOrFail($id);
        return view('petugas.peminjaman.show', compact('peminjaman'));
    }


}