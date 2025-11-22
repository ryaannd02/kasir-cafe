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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_meja');
            $table->string('kode_transaksi');
            $table->unsignedBigInteger('id_kasir'); // relasi ke user kasir
            $table->dateTime('tanggal_transaksi');
            $table->decimal('total_harga', 12, 2);
            $table->decimal('pembayaran_tunai', 12, 2);
            $table->decimal('kembalian', 12, 2);
            $table->timestamps();

            // foreign key ke tabel users
            $table->foreign('id_kasir')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};