<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Cafe',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Manajer Cafe',
            'username' => 'manajer',
            'password' => Hash::make('manajer123'),
            'role' => 'manajer',
        ]);

        User::create([
            'name' => 'Kasir Cafe',
            'username' => 'kasir',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
        ]);
    }
}