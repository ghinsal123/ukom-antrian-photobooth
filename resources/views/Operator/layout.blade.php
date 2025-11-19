<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Panel</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-pink-50">

<div class="flex">

    <!-- SIDEBAR -->
    <nav id="sidebar" class="w-60 h-screen bg-white text-gray-900 p-6 shadow-md fixed top-0 left-0 
        transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 flex flex-col">

        <div>
            <!-- LOGO -->
            <div class="flex items-center gap-3 mb-10">
                <img src="{{ asset('images/logo.png') }}" class="w-14 h-14 drop-shadow">
                <h2 class="text-2xl font-bold text-pink-500">FlashFrame</h2>
            </div>

            <!-- MENU -->
            <div class="space-y-2 font-medium">

                <a href="{{ url('/operator/dashboard') }}"
                   class="flex items-center px-4 py-3 rounded-xl 
                   {{ request()->is('operator/dashboard') 
                        ? 'bg-pink-200 text-pink-600 font-semibold' 
                        : 'text-black hover:bg-pink-100 hover:text-pink-600' }}">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>

                <a href="{{ url('/operator/booth') }}"
                   class="flex items-center px-4 py-3 rounded-xl 
                   {{ request()->is('operator/booth') 
                        ? 'bg-pink-200 text-pink-600 font-semibold' 
                        : 'text-black hover:bg-pink-100 hover:text-pink-600' }}">
                    <i class="fas fa-camera mr-2"></i> Booth
                </a>

                <a href="{{ url('/operator/paket') }}"
                   class="flex items-center px-4 py-3 rounded-xl 
                   {{ request()->is('operator/paket') 
                        ? 'bg-pink-200 text-pink-600 font-semibold' 
                        : 'text-black hover:bg-pink-100 hover:text-pink-600' }}">
                    <i class="fas fa-box mr-2"></i> Paket
                </a>

                <a href="{{ url('/operator/antrian') }}"
                   class="flex items-center px-4 py-3 rounded-xl 
                   {{ request()->is('operator/antrian') 
                        ? 'bg-pink-200 text-pink-600 font-semibold' 
                        : 'text-black hover:bg-pink-100 hover:text-pink-600' }}">
                    <i class="fa-solid fa-people-group mr-2"></i> Antrian
                </a>

                <a href="{{ url('/operator/laporan') }}"
                   class="flex items-center px-4 py-3 rounded-xl 
                   {{ request()->is('operator/laporan') 
                        ? 'bg-pink-200 text-pink-600 font-semibold' 
                        : 'text-black hover:bg-pink-100 hover:text-pink-600' }}">
                    <i class="fas fa-file-alt mr-2"></i> Laporan
                </a>

            </div>
        </div>

        <!-- LOGOUT -->
        <form action="{{ route('operator.logout') }}" method="POST" class="mt-auto pt-4">
            @csrf
            <button class="flex items-center w-full text-left px-4 py-3 rounded-xl hover:bg-red-100 text-red-600 font-medium">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </button>
        </form>

    </nav>
    
    <!-- OVERLAY MOBILE -->
    <div id="overlay" class="fixed inset-0 bg-white/60 z-40 hidden md:hidden"></div>

    <!-- CONTENT WRAPPER -->
    <div class="flex-1 ml-0 md:ml-60">

        <!-- HEADER MOBILE -->
        <div class="md:hidden flex justify-between items-center p-4 bg-white shadow-sm">
            <button id="sidebarToggle" class="text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- FOTO PROFIL MOBILE -->
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama_pengguna) }}" 
                    class="w-10 h-10 rounded-full object-cover border">

                <div class="text-right leading-tight">
                    <p class="font-semibold text-gray-800 text-sm">{{ auth()->user()->nama_pengguna }}</p>
                    <p class="text-gray-500 text-xs">Operator</p>
                </div>
            </div>
        </div>

        <!-- HEADER DESKTOP -->
        <div class="hidden md:flex w-full px-6 py-3 justify-end items-center bg-white shadow-sm rounded-b-lg">
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()->foto ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama_pengguna) }}" 
                    class="w-10 h-10 rounded-full object-cover border">
                <div class="text-right leading-tight">
                    <p class="font-semibold text-gray-800 text-sm">{{ auth()->user()->nama_pengguna }}</p>
                    <p class="text-gray-500 text-xs">Operator</p>
                </div>
            </div>
        </div>

        <!-- PAGE CONTENT -->
        <div class="p-6">
            @yield('content')
        </div>

    </div>

</div>

<script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    // klik overlay = tutup menu
    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
</script>
</body>
</html>
