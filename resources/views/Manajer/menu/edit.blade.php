@extends('layouts.app')

@section('content')
<div class="p-8 max-w-xl mx-auto bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Menu</h1>

    {{-- Pesan error --}}
    @if ($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 border border-red-300">
            <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('menu.update', $menu->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Menu</label>
            <input type="text" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}"
                   class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                   placeholder="Masukkan nama menu" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
            <input type="text" name="kategori" value="{{ old('kategori', $menu->kategori) }}"
                   class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                   placeholder="Masukkan kategori menu" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga</label>
            <input type="number" name="harga" value="{{ old('harga', $menu->harga) }}"
                   class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                   placeholder="Masukkan harga menu" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Stok</label>
            <input type="number" name="stok" value="{{ old('stok', $menu->stok) }}"
                   class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                   placeholder="Masukkan stok menu" required>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('manajer.dashboard') }}"
               class="bg-gray-600 text-white px-5 py-2 rounded-lg hover:bg-gray-500 transition shadow">
               Kembali
            </a>
            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-500 transition shadow">
                Update
            </button>
        </div>
    </form>
</div>
@endsection