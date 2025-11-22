@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Admin</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 border border-green-400 shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol tambah user --}}
    <div class="mb-6">
        <a href="{{ route('admin.users.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition">
           Tambah User Baru
        </a>
    </div>

    {{-- Statistik ringkas --}}
    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-gray-600">Total User</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $users->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-gray-600">Total Transaksi</h2>
            <p class="text-3xl font-bold text-green-600">{{ $transaksiCount ?? 0 }}</p>
        </div>
        <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold text-gray-600">Log Aktivitas</h2>
            <p class="text-3xl font-bold text-purple-600">{{ $logs->count() }}</p>
        </div>
    </div>

    {{-- Daftar User --}}
    <h2 class="text-xl font-semibold mb-2 text-gray-800">Daftar User</h2>
    <div class="overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 mb-6 bg-white rounded shadow">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Username</th>
                    <th class="px-4 py-2 text-left">Role</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->username }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($user->role) }}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-400 transition">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-500 transition"
                                    onclick="return confirm('Yakin hapus user ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Log Aktivitas --}}
    <h2 class="text-xl font-semibold mb-4 text-gray-800">Log Aktivitas Pegawai</h2>
    <div class="bg-white p-4 rounded shadow">
        <ul class="list-disc pl-6 text-gray-700 space-y-2">
            @foreach($logs->take(3) as $log)
                <li>
                    <strong>{{ $log->user->name ?? 'Unknown' }}</strong> - 
                    {{ $log->aktivitas }} 
                    <span class="text-gray-500">({{ $log->created_at->format('d M Y H:i') }})</span>
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            <a href="{{ route('admin.log') }}" 
                class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500 transition">
                Lihat Semua
            </a>
        </div>
    </div>

</div>
@endsection