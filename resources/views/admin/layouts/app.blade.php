<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - FlashFrame</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-pink-50 md:flex">

    {{-- SIDEBAR DESKTOP --}}
    <aside class="hidden md:flex w-64 min-h-screen bg-white shadow-xl p-6 relative flex-col">

        {{-- Glow Background --}}
        <div class="absolute inset-0 -z-10 opacity-50 blur-2xl bg-linear-to-br from-[#FAD1E6] to-[#E5D4FF]"></div>

        {{-- Logo --}}
        <div class="flex items-center gap-3 mb-10">
            <img src="{{ asset('images/logo.png') }}" class="w-12 h-12 drop-shadow">
            <h2 class="text-2xl font-bold text-pink-500">FlashFrame</h2>
        </div>

        {{-- MENU NAVBAR --}}
        <nav class="space-y-2 font-medium flex-1">
            <a href="/admin/dashboard" class="block px-4 py-3 rounded-xl hover:bg-pink-100 
                {{ request()->is('admin/dashboard') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>

            <a href="/admin/booth" class="block px-4 py-3 rounded-xl hover:bg-pink-100 
                {{ request()->is('admin/booth*') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                <i class="fas fa-camera mr-2"></i> Booth
            </a>

            <a href="/admin/paket" class="block px-4 py-3 rounded-xl hover:bg-pink-100 
                {{ request()->is('admin/paket*') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                <i class="fas fa-box mr-2"></i> Paket
            </a>

            <a href="/admin/pengguna" class="block px-4 py-3 rounded-xl hover:bg-pink-100 
                {{ request()->is('admin/pengguna*') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                <i class="fas fa-user mr-2"></i> Pengguna
            </a>

            <a href="/admin/log" class="block px-4 py-3 rounded-xl hover:bg-pink-100 
                {{ request()->is('admin/log*') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                <i class="fas fa-file-alt mr-2"></i> Laporan
            </a>
        </nav>

        {{-- Logout --}}
        <form id="logout-admin" action="{{ route('admin.logout') }}" method="POST" class="pt-4 pb-8">
            @csrf
            <button type="button"
                onclick="if(confirm('Yakin ingin logout?')) document.getElementById('logout-admin').submit();"
                class="block w-full text-left px-4 py-3 rounded-xl hover:bg-red-100 text-red-600 font-medium">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>
    </aside>


    {{-- SIDEBAR MOBILE --}}
    <div id="mobile-sidebar" 
        class="fixed inset-0 z-50 bg-black/40 hidden md:hidden"
        onclick="toggleSidebar()">

        <div class="w-64 min-h-full bg-white p-6 shadow-xl"
             onclick="event.stopPropagation()">

            {{-- Logo Mobile--}}
            <div class="flex items-center gap-3 mb-10">
                <img src="{{ asset('images/logo.png') }}" class="w-12 h-12 drop-shadow">
                <h2 class="text-2xl font-bold text-pink-500">FlashFrame</h2>
            </div>

            {{-- MENU NAVBAR--}}
            <nav class="space-y-2 font-medium">
                <a href="/admin/dashboard" class="block px-4 py-3 rounded-xl hover:bg-pink-100 
                    {{ request()->is('admin/dashboard') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>

                <a href="/admin/booth" class="block px-4 py-3 rounded-xl hover:bg-pink-100 
                    {{ request()->is('admin/booth*') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                    <i class="fas fa-camera mr-2"></i> Booth
                </a>

                <a href="/admin/paket" class="block px-4 py-3 rounded-xl hover:bg-pink-100 
                    {{ request()->is('admin/paket*') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                    <i class="fas fa-box mr-2"></i> Paket
                </a>

                <a href="/admin/pengguna" class="block px-4 py-3 rounded-xl hover:bg-pink-100 
                    {{ request()->is('admin/pengguna*') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                    <i class="fas fa-user mr-2"></i> Pengguna
                </a>

                <a href="/admin/log" class="block px-4 py-3 rounded-xl hover:bg-pink-100 
                    {{ request()->is('admin/log*') ? 'bg-pink-200 font-semibold text-pink-600' : '' }}">
                    <i class="fas fa-file-alt mr-2"></i> Laporan
                </a>

                {{-- Logout --}}
                <form id="logout-admin-mobile" action="{{ route('admin.logout') }}" method="POST" class="pt-4 pb-4">
                    @csrf
                    <button type="button"
                        onclick="if(confirm('Yakin ingin logout?')) document.getElementById('logout-admin-mobile').submit();"
                        class="block w-full text-left px-4 py-3 rounded-xl hover:bg-red-100 text-red-600 font-medium">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>

            </nav>
        </div>
    </div>


    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-6 md:p-8 pb-24">

        {{-- TOPBAR MOBILE --}}
        <header class="flex flex-col gap-3 mb-6 md:hidden">

            {{-- Baris atas: burger + profile --}}
            <div class="flex justify-between items-center">

                {{-- Burger --}}
                <button onclick="toggleSidebar()" class="text-3xl text-pink-600">
                    <i class="fas fa-bars"></i>
                </button>

                {{-- Profile --}}
                <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow">
                    @php
                        $foto = $admin->foto
                            ? asset('storage/' . $admin->foto)
                            : asset('images/profile.png');
                    @endphp
                    <img class="w-10 h-10 rounded-full object-cover" src="{{ $foto }}">
                    <p class="font-semibold text-sm">{{ $admin->nama_pengguna ?? 'Admin' }}</p>
                </div>

            </div>

            {{-- Baris bawah: Judul --}}
            <h1 class="text-2xl font-bold text-gray-700 ml-5 mt-5">
                @yield('title')
            </h1>

        </header>


        {{-- TOPBAR DESKTOP --}}
        <header class="hidden md:flex justify-between items-center mb-8">

            <h1 class="text-3xl font-bold text-gray-700">@yield('title')</h1>

            {{-- Profile Desktop --}}
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow">
                <img class="w-10 h-10 rounded-full object-cover" src="{{ $foto }}">
                <p class="font-semibold text-base">{{ $admin->nama_pengguna ?? 'Admin' }}</p>
            </div>

        </header>

        {{-- PAGE CONTENT --}}
        @yield('content')

    </main>

    {{-- JS SCRIPT --}}
    <script>
        function toggleSidebar() {
            document.getElementById('mobile-sidebar').classList.toggle('hidden');
        }
    </script>

</body>
</html>
