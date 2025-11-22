@extends('layouts.app')

@section('content')
<div class="p-8 max-w-3xl mx-auto bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Buat Transaksi Baru</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 mb-6 rounded-lg border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if($errors->any())
        <div class="bg-red-50 text-red-700 p-4 mb-6 rounded-lg border border-red-300">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('transaksi.store') }}" class="space-y-6">
        @csrf

        {{-- Nomor Meja --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Nomor Meja</label>
            <input type="text" name="nomor_meja"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Masukkan nomor meja" required>
        </div>

        {{-- Tabel Menu --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Pilih Menu</h2>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-300 bg-white rounded-lg shadow">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="px-4 py-2 text-center">Pilih</th>
                            <th class="px-4 py-2 text-left">Menu</th>
                            <th class="px-4 py-2 text-left">Harga</th>
                            <th class="px-4 py-2 text-left">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="border px-4 py-2 text-center">
                                <input type="checkbox" name="menu_id[]" value="{{ $menu->id }}">
                            </td>
                            <td class="border px-4 py-2">{{ $menu->nama_menu }}</td>
                            <td class="border px-4 py-2 text-green-600 font-semibold">
                                {{ number_format($menu->harga, 0, ',', '.') }}
                            </td>
                            <td class="border px-4 py-2">
                                <input type="number" name="jumlah[{{ $menu->id }}]" value="1" min="1"
                                       class="w-24 border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pembayaran --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Pembayaran Tunai</label>
            <input type="number" name="pembayaran_tunai"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Masukkan jumlah pembayaran" required>
        </div>

        {{-- Total Harga --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Total Harga (otomatis)</label>
            <input type="text" id="total_harga"
                   class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100 text-gray-700"
                   readonly>
        </div>

        {{-- Kembalian --}}
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Kembalian (otomatis)</label>
            <input type="text" id="kembalian"
                   class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100 text-gray-700"
                   readonly>
        </div>

        {{-- Tombol Submit --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-500 transition">
                Simpan Transaksi
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('input[name="menu_id[]"]');
    const hargaMap = {
        @foreach($menus as $menu)
            {{ $menu->id }}: {{ $menu->harga }},
        @endforeach
    };

    function hitungTotal() {
        let total = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                const id = cb.value;
                const jumlahInput = document.querySelector(`input[name="jumlah[${id}]"]`);
                const jumlah = jumlahInput ? parseInt(jumlahInput.value) : 0;
                total += hargaMap[id] * jumlah;
            }
        });

        document.getElementById('total_harga').value = total;

        const bayar = parseInt(document.querySelector('input[name="pembayaran_tunai"]').value || 0);
        document.getElementById('kembalian').value = bayar >= total ? bayar - total : 0;
    }

    checkboxes.forEach(cb => cb.addEventListener('change', hitungTotal));
    document.querySelectorAll('input[name^="jumlah"]').forEach(input => input.addEventListener('input', hitungTotal));
    document.querySelector('input[name="pembayaran_tunai"]').addEventListener('input', hitungTotal);
});
</script>
@endsection