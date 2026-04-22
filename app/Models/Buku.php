<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    
    protected $fillable = [
    'kategori_id', 
    'judul_buku', 
    'penulis', 
    'stok', 
    'foto_buku'
];

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}