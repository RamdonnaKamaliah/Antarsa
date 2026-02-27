<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Alat;
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

    if($request->hasFile('qr_file')){
        $request->validate([
                'qr_file' => 'image|required',
                'peminjaman_id' => 'required'
            ]);
            
    $path = $request->file('qr_file')->getRealPath();
    $qr = new \Zxing\QrReader($path);
    $kodeBarang = $qr->text();

    if(!$kodeBarang){
        return back()->with('error', 'qr tidak terbaca');
    }
    
    $request->merge(['kode_barang' => $kodeBarang]);
    
    }    

   $request->validate([
    'kode_barang' => 'required',
    'id_peminjaman' => 'required'
   ]);

   // Cari detail peminjaman berdasarkan kode barang
    $detail = DetailPeminjaman::with('alat')->where('id_peminjaman', $request->peminjaman_id)
        ->whereHas('alat', function ($q) use ($request) {
            $q->where('kode_barang', $request->kode_barang);
        })
        ->where('status_pengambilan', '!=', 'diambil')
        ->first();

    if (!$detail) {
        return back()->with('error', 'Barang tidak ditemukan atau sudah diambil');
    }

    if ($detail->alat->stok < $detail->jumlah) {
        return back()->with('error', 'Stok tidak mencukupi');
    }

    $detail->alat->decrement('stok', $detail->jumlah);

    $detail->update([
        'status_pengambilan' => 'diambil',
        'tanggal_pengambilan' => now()
    ]);

    $peminjaman = $detail->peminjaman;
    $masihAda = $peminjaman->detail()->where('status', '!=', 'diambil')->exists();

     if (!$masihAda) {
            $peminjaman->update([
                'status' => 'dipinjam',
                'tanggal_diambil' => now()
            ]);
        }
    
    return back()->with('success', 'Barang berhasil diverifikasi & diambil');
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