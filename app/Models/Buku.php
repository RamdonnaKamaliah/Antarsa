<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    
    use SoftDeletes; 

    protected $dates = ['deleted_at'];

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