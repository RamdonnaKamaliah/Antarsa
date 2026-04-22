<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{

    public function index()
    {
        $keranjang = session('keranjang', []);
        return view('peminjam.keranjang.index', compact('keranjang'));
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

         return redirect()->route('siswa.keranjang.index')
            ->with('success', 'Alat berhasil ditambahkan ke keranjang!');
    }

    public function checkout(Request $request)
{
    $request->validate([
        'alat_selected' => 'required|array'
    ]);

    $selected = $request->alat_selected;

    dd("Yang dicheckout:", $selected);
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

        return redirect()->route('peminjam.keranjang.index')
            ->with('success', 'Item berhasil dihapus!');
    }
}