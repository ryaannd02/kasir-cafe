@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Laporan Pendapatan</h1>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('manajer.laporan') }}" 
          class="mb-8 flex space-x-6 bg-white p-6 rounded-lg shadow">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal</label>
            <input type="date" name="tanggal" value="{{ $tanggal }}"
                   class="border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Bulan</label>
            <input type="number" name="bulan" value="{{ $bulan }}" min="1" max="12"
                   class="border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun</label>
            <input type="number" name="tahun" value="{{ $tahun }}"
                   class="border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="flex items-end">
            <button type="submit" 
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-500 transition">
                Filter
            </button>
        </div>
    </form>

    {{-- Pendapatan Harian --}}
    <div class="mb-6 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-gray-700 mb-2">Pendapatan Harian ({{ $tanggal }})</h2>
        <p class="text-2xl font-bold text-green-600">
            Rp {{ number_format($pendapatanHarian, 0, ',', '.') }}
        </p>
    </div>

    {{-- Pendapatan Bulanan --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-gray-700 mb-2">Pendapatan Bulanan ({{ $bulan }}/{{ $tahun }})</h2>
        <p class="text-2xl font-bold text-purple-600">
            Rp {{ number_format($pendapatanBulanan, 0, ',', '.') }}
        </p>
    </div>
</div>
@endsection