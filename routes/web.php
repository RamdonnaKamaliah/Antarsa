<?php

use App\Http\Controllers\Admin\AdminAktivitasController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPeminjamanController;
use App\Http\Controllers\Admin\AdminPengembalianController;
use App\Http\Controllers\Admin\AkunPenggunaController;
use App\Http\Controllers\Admin\DaftarAlatController;
use App\Http\Controllers\Admin\DaftarLaporanController;
use App\Http\Controllers\Admin\KategoriAlatController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Peminjam\DataAlatController;
use App\Http\Controllers\Peminjam\KeranjangController;
use App\Http\Controllers\Peminjam\PeminjamanAlatController;
use App\Http\Controllers\Peminjam\PeminjamDashboardController;
use App\Http\Controllers\Peminjam\PeminjamProfileController;
use App\Http\Controllers\Peminjam\PengembalianAlatController;
use App\Http\Controllers\Petugas\LaporanController;
use App\Http\Controllers\Petugas\PeminjamanController;
use App\Http\Controllers\Petugas\PengembalianController;
use App\Http\Controllers\Petugas\PetugasDashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/kategori-alat', KategoriAlatController::class);
    Route::resource('/data-alat', DaftarAlatController::class);
    Route::resource('/akun-pengguna', AkunPenggunaController::class);
    Route::resource('/aktivitas', AdminAktivitasController::class);
    Route::resource('/peminjaman', AdminPeminjamanController::class);
    Route::resource('/pengembalian', AdminPengembalianController::class);
    Route::patch('/akun-pengguna/{id}/unblock', [AkunPenggunaController::class, 'unblock'])->name('akun-pengguna.unblock');

});     

//petugas
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {

    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

    // peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::get('/peminjaman/{id}/scan', [PeminjamanController::class, 'scan'])->name('peminjaman.scan');
    Route::post('/peminjaman/scan/verify', [PeminjamanController::class, 'verifyScan'])->name('peminjaman.scan.verify');
    Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::post('/pengembalian/verify/{id}', [PengembalianController::class, 'verifyPengembalian'])
    ->name('pengembalian.verifyPengembalian');
    Route::get('/laporan/peminjaman', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/peminjaman/unduh', [LaporanController::class, 'unduh'])->name('laporan.unduh');

    
});

//peminjam
Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {

    Route::get('/dashboard', [PeminjamDashboardController::class, 'index'])->name('dashboard');
    Route::resource('data-alat', DataAlatController::class);
    Route::get('/peminjamAlat', [PeminjamanAlatController::class, 'index'])->name('peminjamAlat');
    Route::get('/pengembalianAlat', [PengembalianAlatController::class, 'index'])->name('pengembalianAlat');
    Route::get('/pengembalianAlat/{id}', [PengembalianAlatController::class, 'show'])->name('pengembalianAlat.show');
    Route::resource('/profile-peminjam', PeminjamProfileController::class);
    Route::get('/keranjang', [KeranjangController::class, 'index'])
    ->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'update'])
    ->name('keranjang.update');
    Route::get('peminjaman-alat/{id}/download-qr', [PeminjamanAlatController::class, 'downloadQr'])
         ->name('peminjaman.downloadQr');
    //simpan dari menu cekout ke tabel peminjaman
    Route::post('/keranjang/checkout', [PeminjamanAlatController::class, 'store'])
    ->name('keranjang.checkout');
    Route::get('/peminjaman/{id}', [PeminjamanAlatController::class, 'show'])->name('peminjaman.show');

});




require __DIR__.'/auth.php';