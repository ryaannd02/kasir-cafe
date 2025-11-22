<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::create([
            'nama_menu' => 'Kopi Hitam',
            'kategori' => 'Minuman',
            'harga' => 15000,
            'stok' => 50,
        ]);

        Menu::create([
            'nama_menu' => 'Nasi Goreng',
            'kategori' => 'Makanan',
            'harga' => 25000,
            'stok' => 30,
        ]);
    }
}