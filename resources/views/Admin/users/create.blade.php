@extends('layouts.app')

@section('content')
<div class="p-8 max-w-xl mx-auto bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Tambah User Baru</h1>

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

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
            <input type="text" name="name"
                   class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                   placeholder="Masukkan nama lengkap" required>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
            <input type="text" name="username"
                   class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                   placeholder="Masukkan username unik" required>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
            <input type="password" name="password"
                   class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                   placeholder="Masukkan password" required>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
            <select name="role"
                    class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                    required>
                <option value="kasir">Kasir</option>
                <option value="manajer">Manajer</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.dashboard') }}"
               class="bg-gray-600 text-white px-5 py-2 rounded-lg hover:bg-gray-500 transition shadow">
               Kembali
            </a>
            <button type="submit"
                    class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-500 transition shadow">
                Simpan User
            </button>
        </div>
    </form>
</div>
@endsection