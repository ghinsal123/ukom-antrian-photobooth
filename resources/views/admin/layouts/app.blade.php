<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - FlashFrame</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="flex bg-pink-50">

    <!-- SIDEBAR -->
    <aside class="w-64 min-h-screen bg-white shadow-xl p-6 relative overflow-hidden">

        <!-- Glow Background -->
        <div class="absolute inset-0 -z-10 opacity-50 blur-2xl bg-linear-to-br from-[#FAD1E6] to-[#E5D4FF]"></div>

        <!-- Logo -->
        <div class="flex items-center gap-3 mb-10">
            <img src="{{ asset('images/logo.png') }}" class="w-12 h-12 drop-shadow">
            <h2 class="text-2xl font-bold text-pink-500">FlashFrame</h2>
        </div>

        <!-- MENU -->
        <nav class="space-y-2 font-medium">

            <a href="/admin/dashboard" class="block px-4 py-3 rounded-xl hover:bg-pink-100 {{ request()->is('admin/dashboard') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>

            <a href="/admin/booths" class="block px-4 py-3 rounded-xl hover:bg-pink-100 {{ request()->is('admin/booths') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                <i class="fas fa-camera mr-2"></i> Booth
            </a>

            <a href="/admin/packages" class="block px-4 py-3 rounded-xl hover:bg-pink-100 {{ request()->is('admin/packages') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                <i class="fas fa-box mr-2"></i> Paket
            </a>

            <a href="/admin/pengguna" class="block px-4 py-3 rounded-xl hover:bg-pink-100 {{ request()->is('admin/pengguna') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                <i class="fas fa-user mr-2"></i> Pengguna
            </a>

            <a href="/admin/reports" class="block px-4 py-3 rounded-xl hover:bg-pink-100 {{ request()->is('admin/reports') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                <i class="fas fa-file-alt mr-2"></i> Laporan
            </a>

            <!-- LOGOUT BUTTON -->
            <form action="{{ route('admin.logout') }}" method="POST" class="pt-3">
                @csrf
                <button class="block w-full text-left px-4 py-3 rounded-xl hover:bg-red-100 text-red-600 font-medium">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>

        </nav>
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-8 pb-20"> <!-- Tambahin padding bawah biar konten ga ketutup footer -->

        <!-- TOPBAR -->
        <header class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-700">@yield('title')</h1>

            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow">
                @php
                    $foto = $admin->foto
                        ? asset('storage/' . $admin->foto)
                        : asset('images/default-avatar.png');
                @endphp
                <img class="w-10 h-10 rounded-full object-cover" src="{{ $foto }}">
                <div>
                    <p class="font-semibold">{{ $admin->nama_pengguna ?? 'Admin' }}</p>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        @yield('content')

    </main>

    <!-- FOOTER -->
    <footer class="fixed bottom-0 left-0 w-full text-center py-3 bg-white text-gray-400 text-sm shadow-inner">
        © FlashFrame • 2025
    </footer>

</body>
</html>
