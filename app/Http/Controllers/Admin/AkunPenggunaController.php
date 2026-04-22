<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\KirimPasswordUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash; // Untuk Hash::make
use Illuminate\Support\Str; // Untuk Str::random dan Str::uuid


class AkunPenggunaController extends Controller
{
   public function index() {
    $stats = [
        'total_pengguna' => User::count(),
        'total_role' => User::distinct('role')->count(),
        'total_email' => User::count(), 
    ];

   $akun = User::orderBy('created_at', 'desc')->get();

    return view('admin.data_pengguna.index', compact('akun', 'stats'));
}



    public function create() {
        return view('admin.data_pengguna.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
        ]);

        $passwordRandom = Str::random(8);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email'=> $request->email,
            'password' => Hash::make($passwordRandom),
            'role' => 'siswa',
            'id_user' => Str::uuid()
        ]);

        Mail::to($user->email)->send(new KirimPasswordUser($user->name, $passwordRandom));

        Aktivitas::simpanLog('Tambah', 'Akun Pengguna', 'Menambah akun pengguna:' . $user->name );

        return redirect()->route('admin.akun-pengguna.index')->with('success', 'akun berhasil di buat');
    }

    public function unblock($id)
{
    $user = User::findOrFail($id);

    $user->update([
        'status_blokir' => false,
        'masa_blokir' => null
    ]);

    Aktivitas::simpanLog(
        'Update',
        'Akun Pengguna',
        'Membuka blokir akun pengguna ' . $user->name
    );

    return redirect()
        ->route('admin.akun-pengguna.index')
        ->with('success', 'Akun berhasil dibuka blokirnya');
}


    public function destroy(String $id) {
        $akun = User::where('id', $id)->firstOrFail();

        $namaAkun = $akun->name;
        
        $akun->aktivitas()->delete(); 
        $akun->delete();

        Aktivitas::simpanLog('Hapus', 'Akun Pengguna', 'Menghapus akun pengguna' . $namaAkun);

        return redirect()->route('admin.akun-pengguna.index')->with('success', 'Akun berhasil di hapus');
    }

    public function show(String $id){
        $user = User::findOrFail($id);
        return view('admin.data_pengguna.show', compact('user'));
    }

   
}