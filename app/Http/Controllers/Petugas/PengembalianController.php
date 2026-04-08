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
            'kode_barang'   => 'required', 
            'kondisi'       => 'required|in:baik,rusak',
        ]);

        // 2. Cari Detail Peminjaman yang sedang dipinjam ('diambil')
        $detail = DetailPeminjaman::with(['alat', 'peminjaman'])
            ->where('id_peminjaman', $request->id_peminjaman)
            ->whereHas('alat', function ($q) use ($request) {
                $q->where('kode_barang', $request->kode_barang);
            })
            ->where('status_pengambilan', 'diambil') 
            ->first();

        if (!$detail) {
            return back()->with('error', 'Data peminjaman tidak ditemukan atau sudah dikembalikan.');
        }

        return DB::transaction(function () use ($detail, $request) {
            
            // 3. Update Status di Tabel Detail
            $detail->update([
                'status_pengambilan' => 'kembali',
                'tanggal_kembali'    => now(),
                'kondisi_barang'     => $request->kondisi
            ]);

            // 4. Update Stok Alat (Jika BAIK, stok kembali. Jika RUSAK, stok tidak kembali/masuk maintenance)
            if ($request->kondisi == 'baik') {
                $detail->alat->increment('stok', $detail->jumlah);
            }

            // 5. Cek apakah SEMUA barang dalam transaksi ini sudah kembali
            $peminjaman = $detail->peminjaman;
            $masihAdaBarangDipinjam = $peminjaman->detail()
                ->where('status_pengambilan', 'diambil')
                ->exists();

            // 6. Jika semua sudah kembali, update status utama Peminjaman
            if (!$masihAdaBarangDipinjam) {
                $adaKerusakan = $peminjaman->detail()->where('kondisi_barang', 'rusak')->exists();
                
                $peminjaman->update([
                    'status' => 'dikembalikan',
                    'tanggal_pengembalian_sebenarnya' => now(),
                    'keterangan' => $adaKerusakan ? 'Selesai dengan kerusakan' : 'Selesai tanpa kendala'
                ]);
            }

            return back()->with('success', 'Barang ' . $detail->alat->nama_alat . ' berhasil dikembalikan dengan kondisi ' . $request->kondisi);
        });
    }

public function cekQrPengembalian(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required',
            'kode_barang_target' => 'required',
            'qr_file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // --- LOGIKA DEKRIPSI QR FILE ---
            // Contoh menggunakan library Zxing (sesuaikan dengan library-mu)
            // $image = $request->file('qr_file')->getRealPath();
            // $qrcode = new QrReader($image);
            // $hasil_scan = $qrcode->text(); 

            // Untuk testing sementara, kita anggap hasil scan adalah isi dari file tersebut
            // Ganti baris ini dengan logika pembacaan QR yang sebenarnya
            $hasil_scan = $request->kode_barang_target; // Simulasi: Anggap QR selalu benar

            // Cek kecocokan
            if ($hasil_scan === $request->kode_barang_target) {
                // Berhasil: Kirim sinyal ke Blade untuk buka modal kondisi
                return back()->with([
                    'open_condition_modal' => true,
                    'peminjaman_id' => $request->id_peminjaman,
                    'kode_barang' => $hasil_scan,
                    'success' => 'QR Code Valid! Silakan pilih kondisi barang.'
                ]);
            }

            return back()->with('error', 'QR Code tidak cocok dengan barang yang dipilih.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membaca QR Code: ' . $e->getMessage());
        }
    }
   
}