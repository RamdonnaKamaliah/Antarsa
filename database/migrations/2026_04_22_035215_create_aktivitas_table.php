<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aktivitas', function (Blueprint $table) {
            $table->uuid('id_log')->primary(); // Sesuai kodingan kamu pakai UUID
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); 
            $table->string('aksi');     // Contoh: 'Tambah', 'Edit', 'Hapus'
            $table->string('entitas');  // Contoh: 'Akun Pengguna', 'Buku'
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivitas');
    }
};