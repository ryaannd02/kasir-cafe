<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaksi',
        'id_menu',
        'jumlah',
        'subtotal',
    ];

    // Relasi ke transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    // Relasi ke menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu');
    }
}