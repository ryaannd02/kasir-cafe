@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Kasir</h1>

    {{-- Tombol buat transaksi --}}
    <div class="mb-6">
        <a href="{{ route('transaksi.create') }}" 
           class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-500 transition">
           Buat Transaksi
        </a>
    </div>

    {{-- Histori Transaksi --}}
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Histori Transaksi</h2>
    <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 bg-white rounded-lg shadow">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 text-left">Kode</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Total</th>
                    <th class="px-4 py-2 text-left">Kembalian</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $trx)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border px-4 py-2">{{ $trx->kode_transaksi }}</td>
                    <td class="border px-4 py-2">{{ $trx->tanggal_transaksi }}</td>
                    <td class="border px-4 py-2 text-green-600 font-semibold">{{ $trx->total_harga }}</td>
                    <td class="border px-4 py-2 text-blue-600">{{ $trx->kembalian }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection