<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjamans extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tgl_booking',
        'tgl_pinjam',
        'tgl_kembali_rencana',
        'tgl_kembali_sebenarnya',
        'status',
        'alasan_penolakan',
    ];

    /**
     * Agar field tanggal otomatis dikonversi menjadi objek Carbon.
     * Ini memudahkan kamu untuk melakukan perhitungan (seperti addDays atau diffInDays).
     */
    protected $casts = [
        'tgl_booking' => 'datetime',
        'tgl_pinjam' => 'date',
        'tgl_kembali_rencana' => 'date',
        'tgl_kembali_sebenarnya' => 'date',
    ];

    /**
     * Relasi ke User (Siswa yang meminjam)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Buku (Buku/Alat yang dipinjam)
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}