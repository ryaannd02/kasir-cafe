<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Kasir Cafe</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-900 text-white px-6 py-4 shadow-lg">
        <div class="flex justify-between items-center">
            <!-- Branding -->
            <span class="text-xl font-bold tracking-wide">Cafe Gen-Z</span>

            <!-- Logout -->
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg shadow transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="p-6">
        @yield('content')
    </main>
</body>
</html>