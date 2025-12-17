@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-100 min-h-screen">
    <div id="struk" class="max-w-sm mx-auto border p-4 rounded shadow bg-white font-mono text-sm">
        <h2 class="text-lg font-bold text-center mb-4 border-b pb-2">STRUK TRANSAKSI</h2>

        <p>Kode : {{ $trx->kode_transaksi }}</p>
        <p>Tanggal : {{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d M Y H:i') }}</p>
        <p>Nomor Meja : {{ $trx->nomor_meja }}</p>
        <p>Kasir : {{ $trx->kasir->name }}</p>

        <hr class="my-2">

        <h3 class="font-semibold mb-2">Menu Dipesan</h3>
        @foreach($trx->details as $item)
            <div class="flex justify-between">
                <span>{{ $item->menu->nama_menu }} (x{{ $item->jumlah }})</span>
                <span>Rp {{ number_format($item->subtotal,0,',','.') }}</span>
            </div>
        @endforeach

        <hr class="my-2">

        <p>Total : Rp {{ number_format($trx->total_harga,0,',','.') }}</p>
        <p>Pembayaran : Rp {{ number_format($trx->pembayaran_tunai,0,',','.') }}</p>
        <p>Kembalian : Rp {{ number_format($trx->kembalian,0,',','.') }}</p>

        {{-- Tombol hanya tampil di layar, tidak di print --}}
        <div class="mt-4 flex justify-center space-x-3 no-print">
            <button onclick="window.print()" 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">
                Cetak Struk
            </button>
            <a href="{{ route('kasir.transaksi.index') }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-500">
                Kembali
            </a>
        </div>
    </div>
</div>

{{-- CSS khusus print --}}
<style>
    @media print {
        body * {
            visibility: hidden; /* sembunyikan semua */
        }
        #struk, #struk * {
            visibility: visible; /* hanya struk yang terlihat */
        }
        #struk {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none;
            border: none;
        }
        .no-print {
            display: none !important; /* sembunyikan tombol saat print */
        }
    }
</style>
@endsection