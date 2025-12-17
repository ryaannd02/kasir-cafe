@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Log Aktivitas Pegawai</h1>
        {{-- Tombol kembali --}}
        <a href="{{ route('manajer.dashboard') }}"
           class="inline-flex items-center bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
            Kembali
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="table-auto w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 text-left">Users</th>
                    <th class="px-4 py-2 text-left">Aktivitas</th>
                    <th class="px-4 py-2 text-left">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border px-4 py-2 font-semibold text-gray-800">
                        {{ $log->user->name }}
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
                    <td colspan="3" class="px-4 py-6 text-center text-gray-500">
                        Belum ada log aktivitas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $logs->links() }}
    </div>
</div>
@endsection