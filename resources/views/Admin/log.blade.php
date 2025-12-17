@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    {{-- Header judul + tombol kembali --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Log Aktivitas Pegawai</h1>
<a href="{{ route('admin.dashboard') }}"
   class="inline-flex items-center bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-500 transition">
   Kembali
</a>

    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-6 border border-green-300 shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 bg-white rounded-lg shadow">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 text-left">Pegawai</th>
                    <th class="px-4 py-2 text-left">Aktivitas</th>
                    <th class="px-4 py-2 text-left">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border px-4 py-2 font-semibold text-gray-800">
                        {{ $log->user->name ?? 'Unknown' }}
                    </td>
                    <td class="border px-4 py-2 text-gray-700">
                        {{ $log->aktivitas }}
                    </td>
                    <td class="border px-4 py-2 text-gray-500">
                        {{ $log->created_at->format('d M Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500 py-6">
                        Belum ada log aktivitas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection