<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Kasir Cafe Gen-Z</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center h-screen">
    <div class="w-96 bg-white shadow-xl rounded-lg p-8">
        <!-- Branding -->
        <h1 class="text-2xl font-bold text-center text-indigo-600 mb-2">Cafe Gen-Z</h1>
        <h2 class="text-xl font-semibold mb-6 text-center text-gray-800">Login</h2>

        {{-- Pesan error --}}
        @if($errors->any())
            <div class="bg-red-50 text-red-700 p-3 mb-6 rounded-lg border border-red-300 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Username</label>
                <input type="text" name="username"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                       placeholder="Masukkan username" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-gray-700">Password</label>
                <input type="password" name="password"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                       placeholder="Masukkan password" required>
            </div>
            <button type="submit"
                    class="w-full bg-indigo-600 text-white p-3 rounded-lg shadow hover:bg-indigo-500 transition">
                Login
            </button>
        </form>
    </div>
</body>
</html>