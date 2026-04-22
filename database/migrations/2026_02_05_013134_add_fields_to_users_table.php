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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('id_user')->unique()->after('id');
            $table->string('username')->unique()->after('name');
            $table->enum('role', ['admin', 'siswa'])->default('siswa')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'id_user',
                'role',
                'status_blokir',
                'masa_blokir'
            ]);
        });
    }
};