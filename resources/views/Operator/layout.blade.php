<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

{{-- set viewport responsif --}}
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Operator Panel</title>

{{-- css utama --}}
@vite('resources/css/app.css')

{{-- icon fontawesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-pink-50">
<div class="flex">

{{-- sidebar utama --}}
<nav id="sidebar"
     class="w-60 h-screen bg-white text-gray-900 p-6 shadow-md fixed top-0 left-0 transform -translate-x-full 
            lg:translate-x-0 transition-transform duration-300 z-50 flex flex-col">

    {{-- logo + nama aplikasi --}}
    <div>
        <div class="flex items-center gap-3 mb-10">
            <a href="{{ url('/operator/dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" class="w-14 h-14 drop-shadow">
                <h2 class="text-2xl font-bold text-pink-500">FlashFrame</h2>
            </a>
        </div>

        {{-- menu navigasi --}}
        <div class="space-y-2 font-medium">

            {{-- menu dashboard --}}
            <a href="{{ url('/operator/dashboard') }}"
               class="flex items-center px-4 py-3 rounded-xl 
                      {{ request()->is('operator/dashboard') 
                            ? 'bg-pink-200 text-pink-600 font-semibold' 
                            : 'text-black hover:bg-pink-100 hover:text-pink-600' }}">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>

            {{-- menu booth --}}
            <a href="{{ url('/operator/booth') }}"
               class="flex items-center px-4 py-3 rounded-xl 
                      {{ request()->is('operator/booth') 
                            ? 'bg-pink-200 text-pink-600 font-semibold' 
                            : 'text-black hover:bg-pink-100 hover:text-pink-600' }}">
                <i class="fas fa-camera mr-2"></i> Booth
            </a>

            {{-- menu paket --}}
            <a href="{{ url('/operator/paket') }}"
               class="flex items-center px-4 py-3 rounded-xl 
                      {{ request()->is('operator/paket') 
                            ? 'bg-pink-200 text-pink-600 font-semibold' 
                            : 'text-black hover:bg-pink-100 hover:text-pink-600' }}">
                <i class="fas fa-box mr-2"></i> Paket
            </a>

            {{-- menu antrian --}}
            <a href="{{ url('/operator/antrian') }}"
               class="flex items-center px-4 py-3 rounded-xl 
                      {{ request()->is('operator/antrian') 
                            ? 'bg-pink-200 text-ppink-600 font-semibold' 
                            : 'text-black hover:bg-pink-100 hover:text-pink-600' }}">
                <i class="fa-solid fa-people-group mr-2"></i> Antrian
            </a>

            {{-- menu laporan --}}
            <a href="{{ url('/operator/laporan') }}"
               class="flex items-center px-4 py-3 rounded-xl 
                      {{ request()->is('operator/laporan') 
                            ? 'bg-pink-200 text-pink-600 font-semibold' 
                            : 'text-black hover:bg-pink-100 hover:text-pink-600' }}">
                <i class="fas fa-file-alt mr-2"></i> Laporan
            </a>
        </div>
    </div>

    {{-- tombol logout --}}
    <form id="logoutForm" action="{{ route('operator.logout') }}" method="POST" class="mt-auto pt-4">
        @csrf
        <button type="button" 
            onclick="confirmLogout()" 
            class="flex items-center w-full text-left px-4 py-3 rounded-xl hover:bg-red-100 text-red-600 font-medium">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </button>
    </form>
</nav>

{{-- overlay untuk mobile sidebar --}}
<div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

{{-- area konten utama --}}
<div class="flex-1 ml-0 lg:ml-60">

  {{-- topbar mobile --}}
    <div class="lg:hidden flex justify-between items-center p-4 bg-white shadow-sm sticky top-0 z-50">
        {{-- tombol toggle sidebar --}}
        <button id="sidebarToggle" class="text-gray-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- info user mobile --}}
        <a href="{{ route('operator.profile.edit') }}" class="flex items-center gap-3">
            {{-- Foto --}}
            <img src="{{ auth()->user()->foto 
                    ? asset('storage/' . auth()->user()->foto) 
                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama_pengguna) }}" 
                class="w-11 h-11 rounded-full object-cover border">

            {{-- Nama & Role --}}
            <div class="text-right leading-tight">
                <p class="font-semibold text-gray-800 text-md">{{ auth()->user()->nama_pengguna }}</p>
                <p class="text-gray-500 text-xs">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
        </a>
    </div>

   {{-- topbar desktop --}}
    <div class="hidden lg:flex w-full px-6 py-3 justify-end items-center bg-white shadow-sm rounded-b-lg sticky top-0 z-50">
        <a href="{{ route('operator.profile.edit') }}" class="flex items-center gap-3">
            {{-- Foto klik untuk edit --}}
            <img src="{{ auth()->user()->foto 
                    ? asset('storage/' . auth()->user()->foto) 
                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nama_pengguna) }}" 
                class="w-12 h-12 rounded-full object-cover border">

            {{-- Nama & Role --}}
            <div class="text-right leading-tight">
                <p class="font-semibold text-gray-800 text-lg">{{ auth()->user()->nama_pengguna }}</p>
                <p class="text-gray-500 text-sm">{{ ucfirst(auth()->user()->role) }}</p>
            </div>
        </a>
    </div>

    {{-- konten halaman --}}
    <div class="p-6">
        @yield('content')
    </div>
</div>

</div>

{{-- script toggle sidebar mobile --}}
<script>
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');

sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
});

overlay.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
});
</script>

{{-- script confirm logout --}}
<script>
function confirmLogout() {
    if (confirm('Yakin ingin logout?')) {
        document.getElementById('logoutForm').submit();
    }
}
</script>

</body>
</html>
