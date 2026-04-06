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
     dd('sampai sini', $request->all());    
    //handle request
     if ($request->hasFile('qr_file')) {
        $request->validate([
            'qr_file'       => 'required|image',
            'peminjaman_id' => 'required'
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

    //validate
    $request->validate([
        'kode_barang' => 'required',
        'id_peminjaman' => 'required'
    ]);

    $detail = DetailPeminjaman::with(['alat', 'peminjaman'])
        ->where('id_peminjaman', $request->id_peminjaman)
        ->whereHas('alat', function ($q) use ($request){
           $q->where('kode_barang', $request->kode_barang);
        })
         ->where('status_pengambilan', '!=', 'diambil')
        ->first();

        if(!detail){
            return back()->with('error', 'Barang tidak ditemukan atau sudah diambil');
        }

        if($detail->alat->stok < $detail->jumlah){
            return back()->with('error', 'stok tidak mencukupi');
        }

        $detail->alat->decrement('stok', $detail->jumlah);
        $detail->update([
            'status_pengambilan' => 'diambil',
            'tanggal_pengambilan' => now()
        ]);

         // Cek apakah semua barang sudah diambil
         $masihAda = $detail->peminjaman
        ->detail()
        ->where('status_pengambilan', '!=', 'diambil') 
        ->exists();

    if (!$masihAda) {
        $detail->peminjaman->update([
            'status'         => 'dipinjam',
            'tanggal_diambil' => now()
        ]);
    }

    return back()->with('succes', 'Barang berhasil diverifikasi & diambil');
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