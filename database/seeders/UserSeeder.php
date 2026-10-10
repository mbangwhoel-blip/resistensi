<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan akun admin utama tersedia
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator BBLKL',
                'email' => 'admin@bblkl.go.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'aktif',
                'telepon' => '081234567890',
            ]
        );

        // Akun petugas uji resistensi
        User::firstOrCreate(
            ['username' => 'petugas'],
            [
                'name' => 'Petugas Laboratorium Vektor',
                'email' => 'petugas@bblkl.go.id',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
                'status' => 'aktif',
                'telepon' => '081234567891',
            ]
        );
    }
}
