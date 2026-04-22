<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = [
        'kategori_id',
        'nama_kategori'
    ];

    public function buku() {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}