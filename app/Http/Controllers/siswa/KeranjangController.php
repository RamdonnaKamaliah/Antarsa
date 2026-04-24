<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjamans;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{

    public function index()
{
    $keranjangSession = session('keranjang', []);
    $userId = auth()->id();

    // 1. Ambil detail buku dari DB berdasarkan ID yang ada di session
    $bukuIds = array_keys($keranjangSession);
    $dataBuku = Buku::whereIn('id', $bukuIds)->get()->keyBy('id');

    // 2. Gabungkan data session dengan data dari database
    $keranjang = [];
    foreach ($keranjangSession as $id => $item) {
        if (isset($dataBuku[$id])) {
            $keranjang[$id] = [
                'id' => $id,
                'judul' => $dataBuku[$id]->judul,
                'foto' => $dataBuku[$id]->foto_buku,
                'penulis' => $dataBuku[$id]->penulis,
                'stok' => $dataBuku[$id]->stok,
                'jumlah' => $item['jumlah'] ?? 1,
                'kategori' => $dataBuku[$id]->kategori->nama_kategori ?? 'Umum',
            ];
        }
    }

    $adaTunggakan = Peminjamans::where('user_id', $userId)
    ->where('status', 'disetujui')
    // Pakai toDateString() supaya cuma bandingkan tanggal (Y-m-d) tanpa jam
    ->whereDate('tgl_kembali_rencana', '<', now()->toDateString()) 
    ->whereNull('tgl_kembali_sebenarnya')
    ->exists();


    return view('peminjam.keranjang.index', compact('keranjang', 'adaTunggakan'));
}

    public function tambah($id){
        
        $alat = Buku::findOrFail($id);
        

        $keranjang = session()->get('keranjang', []);

        if(isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] += 1;
        } else {
            $keranjang[$id] = [
                'nama' => $alat->nama_alat,
                'jumlah' => 1
            ];
        }

        session()->put('keranjang', $keranjang);

         return redirect()->route('siswa.data-alat.index')
            ->with('success', 'Alat berhasil ditambahkan ke keranjang!');
    }



public function update(Request $request, $id)
{
    $keranjang = session()->get('keranjang', []);

    if (!isset($keranjang[$id])) {
        return redirect()->back();
    }

    $jumlah = max(1, (int) $request->jumlah);

    $keranjang[$id]['jumlah'] = $jumlah;

    session()->put('keranjang', $keranjang);

    return redirect()->back();
}



    public function hapus($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
        }

        return redirect()->route('siswa.keranjang.index')
            ->with('success', 'Item berhasil dihapus!');
    }
}