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
        Schema::table('detail_peminjaman', function (Blueprint $table) {
             $table->enum('status_pengambilan', ['menunggu', 'diambil'])->default('menunggu');
             $table->dateTime('tanggal_pengambilan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_peminjaman', function (Blueprint $table) {
             $table->dropColumn('status_pengambilan');
             $table->dropColumn('tanggal_pengambilan');
        });
    }
};