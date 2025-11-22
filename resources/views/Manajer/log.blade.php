@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Log Aktivitas Pegawai</h1>

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
                @foreach($logs as $log)
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
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection