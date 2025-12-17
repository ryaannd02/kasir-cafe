{{-- resources/views/kasir/transaksi/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-100 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Pesanan Saya</h1>
<a href="{{ route('kasir.dashboard') }}" 
   class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition">
   Kembali
</a>

    </div>

    {{-- Filter --}}
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white p-4 rounded-lg shadow mb-6">
    <div>
        <label class="text-sm font-semibold text-gray-700">Dari</label>
        <input type="date" name="dari" value="{{ request('dari') }}"
               class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="text-sm font-semibold text-gray-700">Sampai</label>
        <input type="date" name="sampai" value="{{ request('sampai') }}"
               class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label class="text-sm font-semibold text-gray-700">Nomor Meja</label>
        <input type="text" name="nomor_meja" value="{{ request('nomor_meja') }}"
               class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="md:col-span-3 flex justify-end">
        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-500 transition">
            Filter
        </button>
    </div>
</form>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="table-auto w-full">
            <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="px-4 py-2 text-left">Kode</th>
                <th class="px-4 py-2 text-left">Tanggal</th>
                <th class="px-4 py-2 text-left">Nomor Meja</th>
                <th class="px-4 py-2 text-left">Total</th>
                <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($transaksis as $trx)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">{{ $trx->kode_transaksi }}</td>
                    <td class="border px-4 py-2">
                        {{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                    </td>
                    <td class="border px-4 py-2">{{ $trx->nomor_meja }}</td>
                    <td class="border px-4 py-2 text-green-700 font-semibold">
                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('kasir.transaksi.show', $trx->kode_transaksi) }}"
                           class="text-blue-600 hover:text-blue-500">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-4 py-6 text-center text-gray-500" colspan="5">Belum ada transaksi.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $transaksis->links() }}
    </div>
</div>
@endsection