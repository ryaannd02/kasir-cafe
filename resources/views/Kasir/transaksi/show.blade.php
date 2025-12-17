{{-- resources/views/kasir/transaksi/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-100 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi</h1>
        <div class="flex space-x-3">
            {{-- Tombol kembali --}}
<a href="{{ route('kasir.dashboard') }}" 
   class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition">
   Kembali
</a>

            {{-- Tombol lihat struk --}}
            <a href="{{ route('kasir.transaksi.struk', $trx->kode_transaksi) }}" 
               class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition">
                🧾 Lihat Struk
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Informasi transaksi --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="space-y-2">
                <p><span class="font-semibold">Kode:</span> {{ $trx->kode_transaksi }}</p>
                <p><span class="font-semibold">Tanggal:</span> 
                    {{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                </p>
                <p><span class="font-semibold">Nomor Meja:</span> {{ $trx->nomor_meja }}</p>
                <p><span class="font-semibold">Kasir:</span> {{ $trx->kasir->name }}</p>
                <p><span class="font-semibold">Total:</span> 
                    <span class="text-green-700 font-semibold">
                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                    </span>
                </p>
                <p><span class="font-semibold">Pembayaran:</span> Rp {{ number_format($trx->pembayaran_tunai, 0, ',', '.') }}</p>
                <p><span class="font-semibold">Kembalian:</span> Rp {{ number_format($trx->kembalian, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Detail menu --}}
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-3">Menu Dipesan</h2>
            <div class="space-y-2">
                @forelse($trx->details as $item)
                    <div class="flex justify-between border-b pb-2">
                        <div>
                            <p class="font-semibold">{{ $item->menu->nama_menu }}</p>
                            <p class="text-sm text-gray-500">Jumlah: {{ $item->jumlah }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">
                                Harga: Rp {{ number_format($item->menu->harga, 0, ',', '.') }}
                            </p>
                            <p class="font-semibold text-blue-700">
                                Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada detail menu untuk transaksi ini.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection