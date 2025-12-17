@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-100 min-h-screen">
    <h1 class="text-4xl font-bold mb-10 text-gray-800 text-center">Laporan Pendapatan</h1>

    {{-- Filter Form --}}
    <div class="max-w-4xl mx-auto mb-10">
        <form method="GET" action="{{ route('manajer.laporan') }}" 
              class="grid grid-cols-1 md:grid-cols-4 gap-6 bg-white p-6 rounded-xl shadow-lg">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}"
                       class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Bulan</label>
                <input type="number" name="bulan" value="{{ $bulan }}" min="1" max="12"
                       class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun</label>
                <input type="number" name="tahun" value="{{ $tahun }}"
                       class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-500 transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Cards Pendapatan --}}
    <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
        {{-- Pendapatan Harian --}}
        <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition">
            <h2 class="text-lg font-semibold text-gray-700 mb-3">Pendapatan Harian</h2>
            <p class="text-sm text-gray-500 mb-2">Tanggal: {{ $tanggal }}</p>
            <p class="text-3xl font-bold text-green-600">
                Rp {{ number_format($pendapatanHarian, 0, ',', '.') }}
            </p>
        </div>

        {{-- Pendapatan Bulanan --}}
        <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition">
            <h2 class="text-lg font-semibold text-gray-700 mb-3">Pendapatan Bulanan</h2>
            <p class="text-sm text-gray-500 mb-2">Periode: {{ $bulan }}/{{ $tahun }}</p>
            <p class="text-3xl font-bold text-purple-600">
                Rp {{ number_format($pendapatanBulanan, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Tombol kembali di bawah --}}
    <div class="max-w-4xl mx-auto text-center">
        <a href="{{ route('manajer.dashboard') }}"
           class="inline-flex items-center bg-gray-800 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
            Kembali
        </a>
    </div>
</div>
@endsection