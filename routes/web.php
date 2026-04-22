<?php

use App\Http\Controllers\Admin\AdminAktivitasController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPeminjamanController;
use App\Http\Controllers\Admin\AdminPengembalianController;
use App\Http\Controllers\Admin\AkunPenggunaController;
use App\Http\Controllers\Admin\DaftarBukuController;
use App\Http\Controllers\Admin\KategoriAlatController;
use App\Http\Controllers\Siswa\KeranjangController;
use App\Http\Controllers\Siswa\PeminjamanAlatController;
use App\Http\Controllers\siswa\SiswaDashboardController;
use App\Http\Controllers\Peminjam\PeminjamProfileController;
use App\Http\Controllers\Peminjam\PengembalianAlatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\siswa\DataBukuController;
use App\Http\Controllers\siswa\KeranjangController as SiswaKeranjangController;
use App\Http\Controllers\siswa\PeminjamanBukuController;
use App\Http\Controllers\siswa\SiswaProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->role == 'petugas') {
            return redirect()->route('petugas.dashboard');
        } else {
            return redirect()->route('siswa.dashboard');
        }
    }
    return redirect()->route('login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::patch('/approve/{id}', [AdminPeminjamanController::class, 'approve'])->name('approve');
    Route::patch('/kembali/{id}', [AdminPeminjamanController::class, 'kembali'])->name('kembali');
    Route::patch('/reject/{id}', [AdminPeminjamanController::class, 'reject'])->name('reject');
    Route::resource('/kategori-alat', KategoriAlatController::class);
    Route::resource('/data-buku', DaftarBukuController::class);
    Route::resource('/akun-pengguna', AkunPenggunaController::class);
    Route::resource('/aktivitas', AdminAktivitasController::class);
    Route::resource('/peminjaman', AdminPeminjamanController::class);
    Route::resource('/pengembalian', AdminPengembalianController::class);
    Route::patch('/akun-pengguna/{id}/unblock', [AkunPenggunaController::class, 'unblock'])->name('akun-pengguna.unblock');

});     


//siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::resource('data-alat', DataBukuController::class);
    Route::get('/peminjamAlat', [PeminjamanBukuController::class, 'index'])->name('peminjamAlat');
    // Route::get('/pengembalianAlat', [PengembalianAlatController::class, 'index'])->name('pengembalianAlat');
    // Route::get('/pengembalianAlat/{id}', [PengembalianAlatController::class, 'show'])->name('pengembalianAlat.show');
    Route::resource('/profile-peminjam', SiswaProfileController::class);
    Route::get('/keranjang', [KeranjangController::class, 'index'])
    ->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [SiswaKeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::post('/keranjang/checkout' , [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'update'])
    ->name('keranjang.update');
    Route::get('peminjaman-alat/{id}/download-qr', [PeminjamanBukuController::class, 'downloadQr'])
         ->name('peminjaman.downloadQr');
    Route::post('/keranjang/checkout', [PeminjamanBukuController::class, 'store'])
    ->name('keranjang.checkout');
    Route::get('/peminjaman/{id}', [PeminjamanBukuController::class, 'show'])->name('peminjaman.show');

});




require __DIR__.'/auth.php';