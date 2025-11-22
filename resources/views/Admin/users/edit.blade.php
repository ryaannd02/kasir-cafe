@extends('layouts.app')

@section('content')
<div class="p-8 max-w-xl mx-auto bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit User</h1>

    {{-- Pesan error --}}
    @if ($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded mb-6 border border-red-300">
            <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Masukkan nama lengkap" required>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                   class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Masukkan username unik" required>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Password (opsional)</label>
            <input type="password" name="password"
                   class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder="Isi jika ingin mengganti password">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Role</label>
            <select name="role"
                    class="border border-gray-300 p-3 w-full rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>
                <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                <option value="manajer" {{ $user->role == 'manajer' ? 'selected' : '' }}>Manajer</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.dashboard') }}"
               class="bg-gray-600 text-white px-5 py-2 rounded-lg hover:bg-gray-500 transition">
               Kembali
            </a>
            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-500 transition shadow">
                Update User
            </button>
        </div>
    </form>
</div>
@endsection