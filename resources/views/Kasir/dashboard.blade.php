@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-100 min-h-screen">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Kasir</h1>
        <div class="flex gap-3">
            <a href="{{ route('kasir.transaksi.index') }}" 
               class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-500 transition">
               Riwayat Pesanan
            </a>
        </div>
    </div>

    {{-- Layout 2 kolom: Menu & Checkout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom kiri: daftar menu --}}
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($menus as $menu)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $menu->nama_menu }}</h3>
                        <p class="text-sm text-gray-500 mb-1">Kategori: {{ $menu->kategori }}</p>
                        <p class="text-sm text-blue-600 font-semibold mb-1">
                            Harga: Rp {{ number_format($menu->harga,0,',','.') }}
                        </p>
                        <p class="text-sm text-gray-600">Stok: {{ $menu->stok }}</p>
                    </div>
                    <div class="mt-4">
                        <form method="POST" action="{{ route('kasir.cart.add', $menu->id) }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-500 transition">
                                + Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Kolom kanan: keranjang checkout --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Keranjang Checkout</h2>

            {{-- Pesan error dari controller --}}
            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    @foreach($errors->all() as $error)
                        <p>⚠️ {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- Pesan sukses --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('kasir.checkout') }}">
                @csrf

                <div class="space-y-3">
                    @forelse($cartItems as $id => $item)
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <p class="font-semibold">{{ $item['nama_menu'] }}</p>
                                <p class="text-sm text-gray-500">Jumlah: {{ $item['jumlah'] }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                {{-- Tombol kurang --}}
                                <form method="POST" action="{{ route('kasir.cart.decrease', $id) }}">
                                    @csrf
                                    <button type="submit" class="px-2 py-1 bg-gray-300 rounded">-</button>
                                </form>

                                {{-- Tombol tambah --}}
                                <form method="POST" action="{{ route('kasir.cart.increase', $id) }}">
                                    @csrf
                                    <button type="submit" class="px-2 py-1 bg-gray-300 rounded">+</button>
                                </form>

                                {{-- Tombol hapus --}}
                                <form method="POST" action="{{ route('kasir.cart.remove', $id) }}">
                                    @csrf
                                    <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded">x</button>
                                </form>

                                <p class="text-blue-600 font-semibold">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- Hidden input untuk kirim ke transaksi --}}
                        <input type="hidden" name="menus[{{ $id }}][id]" value="{{ $id }}">
                        <input type="hidden" name="menus[{{ $id }}][jumlah]" value="{{ $item['jumlah'] }}">
                    @empty
                        <p class="text-gray-500">Keranjang masih kosong</p>
                    @endforelse
                </div>

                {{-- Total & pembayaran --}}
            <form method="POST" action="{{ route('kasir.checkout') }}">
                @csrf
                {{-- Nomor Meja --}}
                <label class="text-sm font-semibold text-gray-700">Nomor Meja</label>
                <input type="text" name="nomor_meja" placeholder="Nomor Meja"
                    class="w-full border border-gray-300 rounded-lg p-2 mb-3"
                    value="{{ old('nomor_meja') }}">

                {{-- Total --}}
                <p class="text-lg font-bold text-gray-800">
                    Total: Rp {{ number_format($total ?? 0, 0, ',', '.') }}
                </p>

                {{-- Input pembayaran --}}
                <label class="text-sm font-semibold text-gray-700">Pembayaran Tunai</label>
                <input type="number" name="pembayaran_tunai" placeholder="Pembayaran Tunai"
                    class="w-full border border-gray-300 rounded-lg p-2 mb-3"
                    value="{{ old('pembayaran_tunai') }}">

                {{-- Pesan kembalian otomatis --}}
                @if(session('kembalian'))
                    <p class="text-sm text-gray-600">
                        Kembalian: Rp {{ number_format(session('kembalian'), 0, ',', '.') }}
                    </p>
                @endif

                <div class="mt-6">
                    <button type="submit"
                            class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-500 transition">
                        Bayar & Cetak Struk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection