@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Manajer</h1>

    {{-- Navigasi tambahan --}}
    <div class="mb-8 flex space-x-3">
        <a href="{{ route('manajer.laporan') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-500 transition">
           Lihat Laporan Pendapatan
        </a>
        <a href="{{ route('menu.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-500 transition">
           Tambah Menu
        </a>
        <a href="{{ route('manajer.log') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-500 transition">
           Lihat Log Aktivitas
        </a>
    </div>

    {{-- Daftar Transaksi --}}
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Catatan Transaksi</h2>

    <form method="GET" action="{{ route('manajer.dashboard') }}" 
          class="mb-6 flex space-x-6 bg-white p-4 rounded-lg shadow">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Kasir</label>
            <select name="kasir_id" 
                    class="border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">-- Semua Kasir --</option>
                @foreach($kasirs as $kasir)
                    <option value="{{ $kasir->id }}" {{ request('kasir_id') == $kasir->id ? 'selected' : '' }}>
                        {{ $kasir->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                   class="border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="flex items-end">
            <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-500 transition">
                Filter
            </button>
        </div>
    </form>

    <div class="overflow-x-auto mb-8">
        <table class="table-auto w-full border border-gray-300 bg-white rounded-lg shadow">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-2 text-left">Kode Transaksi</th>
                    <th class="px-4 py-2 text-left">Kasir</th>
                    <th class="px-4 py-2 text-left">Nomor Meja</th>
                    <th class="px-4 py-2 text-left">Total Harga</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $trx)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border px-4 py-2">{{ $trx->kode_transaksi }}</td>
                    <td class="border px-4 py-2">{{ $trx->kasir->name }}</td>
                    <td class="border px-4 py-2">{{ $trx->nomor_meja }}</td>
                    <td class="border px-4 py-2 text-green-600 font-semibold">{{ $trx->total_harga }}</td>
                    <td class="border px-4 py-2">{{ $trx->tanggal_transaksi }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Daftar Menu --}}
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Menu Cafe</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($menus as $menu)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $menu->nama_menu }}</h3>
                <p class="text-sm text-gray-500 mb-1">Kategori: {{ $menu->kategori }}</p>
                <p class="text-sm text-blue-600 font-semibold mb-1">Harga: Rp {{ number_format($menu->harga,0,',','.') }}</p>
                <p class="text-sm text-gray-600">Stok: {{ $menu->stok }}</p>
            </div>
            <div class="mt-4 flex space-x-2">
                <a href="{{ route('menu.edit', $menu->id) }}" 
                   class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-400 transition">Edit</a>
                <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-500 transition"
                            onclick="return confirm('Yakin hapus menu ini?')">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection