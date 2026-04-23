<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriAlatController extends Controller     
{
    public function index()
    {
          $stats = [
        'total_alat' => Buku::count(),
        'total_kategori' => Buku::whereNotNull('kategori_id')->count(),
        'total_stok' =>Buku::sum('stok'), 
    ];
        
        $kategori = Kategori::latest()->get();
        return view('admin.kategori_alat.index', compact('kategori'));
    }

    public function create() {
        return view('admin.kategori_alat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Kategori "' . $request->nama_kategori . '" sudah ada.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        try {
            Kategori::create([
                'id_kategori'   => Str::uuid(),
                'nama_kategori' => $request->nama_kategori
            ]);

            Aktivitas::simpanLog('Tambah', 'KATEGORI', 'Menambahkan kategori alat baru:' . $request->nama_kategori);

            return redirect()
                ->route('admin.kategori-alat.index')
                ->with('success', 'Kategori berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit(String $id){
        $kategori = Kategori::where('id', $id)->firstOrFail();
        return view('admin.kategori_alat.edit', compact('kategori'));
    }

    public function update(Request $request, $id){
        $kategori = Kategori::where('id', $id)->firstOrFail();

        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Kategori "' . $request->nama_kategori . '" sudah ada.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

         try {
            $kategori->update([
                'nama_kategori' => $request->nama_kategori
            ]);

            Aktivitas::simpanLog('Update', 'Kategori', 'Mengubah kategori alat:' . $request->nama_kategori);

            return redirect()
                ->route('admin.kategori-alat.index')
                ->with('success', 'Kategori berhasil di ubah!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function destroy(String $id) {
        $kategori = Kategori::where('id', $id)->firstOrFail();

        $namaKategori = $kategori->nama_kategori;

        $kategori->delete();

        Aktivitas::simpanLog('Hapus', 'Kategori Alat', 'Menghapus kategori alat' . $namaKategori);

        return redirect()->route('admin.kategori-alat.index')->with('success', 'data berhasil dihapus');
        
    }
}