<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\Alat;
use App\Models\KategoriAlat;
// use BaconQrCode\Encoder\QrCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;




class DaftarAlatController extends Controller
{
    public function index(){
         $stats = [
        'total_alat' => Alat::count(),
        'total_kategori' => Alat::whereNotNull('id_kategori')->count(),
        'total_qrcode' => Alat::distinct('qr_code')->count(),
        'total_stok' =>Alat::sum('stok'), 
    ];

         $alat = Alat::with('kategori')->latest()->get();
        return view('admin.data_alat.index', compact('alat', 'stats'));
    }

    public function create() {
        $kategori = KategoriAlat::all();
        return view('admin.data_alat.create', compact('kategori'));
    }

    public function show($id){
        $alat = Alat::where('id', $id)->firstOrFail();
        return view('admin.data_alat.show', compact('alat'));
    }
    
    public function store(Request $request){
        $request->validate([
            'id_kategori' => 'required|exists:kategori_alats,id',
            'nama_alat' => 'string|required|max:150',
            'stok' => 'required|integer',
            'foto_alat' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $fotoPath = null;

        if($request->hasFile('foto_alat')){
            $fotoPath = $request->file('foto_alat')->store('alat', 'public');
        }

        try{

            $kodeBarang = 'BRG-' . strtoupper(Str::random(6));
        
            $alat = Alat::create([
                'id_alat' => Str::uuid(),
                'id_kategori' => $request->id_kategori,
                'nama_alat' => $request->nama_alat,
                'stok' => $request->stok,
                'foto_alat' => $fotoPath,
                'qr_code' => $kodeBarang,
                 'kode_barang' => $kodeBarang,
            ]);

            $qrImage = QrCode::format('svg')->size(300)->generate($kodeBarang);
            $fileName = "qr_alat_" . $alat->id_alat . ".svg";

            Storage::disk('public')->put('qrcode/' . $fileName, $qrImage);

            // ✅ Simpan nama file QR ke database
            $alat->qr_code = $fileName;
            $alat->save();
        

            Aktivitas::simpanLog('Tambah', 'Alat', 'Menambahkan alat baru:' . $request->nama_alat);

            return redirect()->route('admin.data-alat.index')->with('success', 'data berhasil ditambah');
        }catch (\Exception $e){
            return back()->withInput()->with('error', 'gagal menyimpan data' . $e->getMessage());
        }
    }

    public function edit(String $id){
        $kategori = KategoriAlat::all();
        $alat = Alat::where('id', $id)->firstOrFail();
        
        return view('admin.data_alat.edit', compact('kategori', 'alat'));
    }

    public function update(Request $request, $id)
{
    $alat = Alat::findOrFail($id);

    $request->validate([
        'nama_alat' => 'required|string|max:255',
        'id_kategori' => 'required|exists:kategori_alats,id',
        'stok' => 'required|integer',
        'foto_alat' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // update data biasa
    $alat->nama_alat = $request->nama_alat;
    $alat->id_kategori = $request->id_kategori;
    $alat->stok = $request->stok;

    if ($request->hasFile('foto_alat')) {

        if ($alat->foto_alat && file_exists(public_path('storage/' . $alat->foto_alat))) {
            unlink(public_path('storage/' . $alat->foto_alat));
        }

        $foto = $request->file('foto_alat')->store('alat', 'public');
        $alat->foto_alat = $foto;
    }   

    $alat->save();

    Aktivitas::simpanLog('Update', 'Alat', 'Mengubah kategori alat baru:' . $request->nama_alat);

    return redirect()->route('admin.data-alat.index')
        ->with('success', 'Data alat berhasil diupdate!');
}


   public function destroy($id) 
{
    
    $alat = Alat::findOrFail($id); 

    try {

        $namaAlat = $alat->nama_alat;

        if ($alat->foto_alat && \Storage::disk('public')->exists($alat->foto_alat)) {
            \Storage::disk('public')->delete($alat->foto_alat);
        }

        $alat->delete();

        Aktivitas::simpanLog('HAPUS', 'ALAT', 'Menghapus alat: ' . $namaAlat);

        return redirect()->route('admin.data-alat.index')->with('success', 'Data berhasil dihapus');
    } catch (Exception $e) {
        return redirect()->route('admin.data-alat.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
}


    
}