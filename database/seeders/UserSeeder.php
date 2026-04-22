<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id_user' => Str::uuid(),
            'name' => 'Admin 1',
            'username' => 'Admin guru',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        
        
        User::create([
            'id_user' => Str::uuid(),
            'name' => 'Siti Kamaliah Ramdona',
            'username' => 'donna',
            'email' => 'donna@gmail.com',
            'password' => Hash::make('donna123'),
            'role' => 'siswa',
            
        ]);
    }
}