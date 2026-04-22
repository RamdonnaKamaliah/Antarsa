<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Buku;
use App\Models\Kategori;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class DaftarBukuController extends Controller
{
    public function index(){
         $stats = [
        'total_Buku' => Buku::count(),
        // 'total_kategori' => Buku::whereNotNull('kategori_id')->count(),
        // 'total_qrcode' => Buku::distinct('qr_code')->count(),
        'total_stok' =>Buku::sum('stok'), 
    ];

         $Buku = Buku::with('kategori')->latest()->get();
        return view('admin.data_buku.index', compact('Buku'));
    }

    public function create() {
        $kategori = Kategori::all();
        return view('admin.data_Buku.create', compact('kategori'));
    }

    public function show($id){
        $Buku = Buku::where('id', $id)->firstOrFail();
        return view('admin.data_Buku.show', compact('Buku'));
    }
    
 public function store(Request $request) {
    $request->validate([
        'kategori_id' => 'required|exists:kategori,id', // Pastikan tabelnya memang 'kategori'
        'judul_buku' => 'string|required|max:150',
        'penulis' => 'string|required|max:150',
        'stok' => 'required|integer',
        'foto_buku' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $fotoPath = null;
    if($request->hasFile('foto_buku')){
        $fotoPath = $request->file('foto_buku')->store('Buku', 'public');
    }

    try {
        // Langsung create tanpa save() lagi di bawahnya
        Buku::create([
            'kategori_id' => $request->kategori_id,
            'judul_buku'  => $request->judul_buku,
            'penulis'     => $request->penulis,
            'stok'        => $request->stok,
            'foto_buku'   => $fotoPath, // PAKAI HURUF KECIL SEMUA (sesuai migration)
        ]);

        Aktivitas::simpanLog('Tambah', 'Buku', 'Menambahkan Buku baru: ' . $request->judul_buku);

        return redirect()->route('admin.data-buku.index')->with('success', 'Data berhasil ditambah');

    } catch (\Exception $e) {
     
         return redirect()->route('admin.data-buku.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
}

    public function edit(String $id){
        $kategori = Kategori::all();
        $Buku = Buku::where('id', $id)->firstOrFail();
        
        return view('admin.data_Buku.edit', compact('kategori', 'Buku'));
    }

    public function update(Request $request, $id)
{
    $Buku = Buku::findOrFail($id);

    $request->validate([
        'judul_buku' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategori,id',
        'penulis' => 'string|required|max:150',
        'stok' => 'required|integer',
        'foto_buku' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // update data biasa
    $Buku->judul_buku = $request->judul_buku;
    $Buku->kategori_id = $request->kategori_id;
    $Buku->penulis = $request->penulis;
    $Buku->stok = $request->stok;

    if ($request->hasFile('foto_buku')) {

        if ($Buku->foto_buku && file_exists(public_path('storage/' . $Buku->foto_buku))) {
            unlink(public_path('storage/' . $Buku->foto_buku));
        }

        $foto = $request->file('foto_buku')->store('Buku', 'public');
        $Buku->foto_buku = $foto;
    }   

    $Buku->save();

    Aktivitas::simpanLog('Update', 'Buku', 'Mengubah kategori Buku baru:' . $request->nama_Buku);

    return redirect()->route('admin.data-buku.index')
        ->with('success', 'Data Buku berhasil diupdate!');
}


   public function destroy($id) 
{
    
    $Buku = Buku::findOrFail($id); 
    
    try {

        $namaBuku = $Buku->judul_buku;

        if ($Buku->foto_buku && \Storage::disk('public')->exists($Buku->foto_buku)) {
            \Storage::disk('public')->delete($Buku->foto_buku);
        }

        $Buku->delete();

        Aktivitas::simpanLog('HAPUS', 'Buku', 'Menghapus Buku: ' . $namaBuku);

        return redirect()->route('admin.data-buku.index')->with('success', 'Data berhasil dihapus');
    } catch (Exception $e) {
        return redirect()->route('admin.data-buku.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
}


    
}