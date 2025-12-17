<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kasir',
        'kode_transaksi',
        'nomor_meja',
        'total_harga',
        'pembayaran_tunai',
        'kembalian',
        'tanggal_transaksi',
    ];

    // Relasi ke kasir (user)
    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir');
    }

    // Relasi ke detail transaksi
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}