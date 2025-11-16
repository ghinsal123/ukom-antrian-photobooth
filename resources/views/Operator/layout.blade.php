<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-pink-50">

<div class="flex">

    <!-- SIDEBAR FIXED -->
    <nav class="w-60 h-screen bg-white text-gray-900 p-6 shadow-md fixed top-0 left-0">
        <h1 class="font-bold text-2xl mb-6 text-pink-400">Photobooth FlashFrame</h1>
    <ul class="space-y-4 font-medium">
        <li>
            <a href="{{ url('/operator/dashboard') }}" 
            class="block {{ request()->is('operator/dashboard') ? 'text-pink-400 font-bold' : 'text-gray-900 hover:text-pink-400' }}">
            Dashboard
            </a>
        </li>
        <li>
            <a href="{{ url('/operator/jadwal') }}" 
            class="block {{ request()->is('operator/jadwal') ? 'text-pink-400 font-bold' : 'text-gray-900 hover:text-pink-400' }}">
            Jadwal
            </a>
        </li>
        <li>
            <a href="{{ url('/operator/paket') }}" 
            class="block {{ request()->is('operator/paket') ? 'text-pink-400 font-bold' : 'text-gray-900 hover:text-pink-400' }}">
            Paket
            </a>
        </li>
        <li>
            <a href="{{ url('/operator/reservasi') }}" 
            class="block {{ request()->is('operator/reservasi') ? 'text-pink-400 font-bold' : 'text-gray-900 hover:text-pink-400' }}">
            Antrian
            </a>
        </li>
        <li>
            <a href="{{ url('/operator/laporan') }}" 
            class="block {{ request()->is('operator/laporan') ? 'text-pink-400 font-bold' : 'text-gray-900 hover:text-pink-400' }}">
            Laporan
            </a>
        </li>
        <li>
            <a href="{{ url('/operator/logout') }}" 
            class="block text-gray-900 hover:text-pink-400">
            Logout
            </a>
        </li>
    </ul>
    </nav>

    <!-- CONTENT -->
    <div class="flex-1 p-6 ml-60"> <!-- ml-60 supaya nggak tertutup sidebar -->
        @yield('content')
    </div>

</div>

</body>
