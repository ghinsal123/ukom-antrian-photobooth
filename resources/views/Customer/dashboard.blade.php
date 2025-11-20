<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-400">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center">
                <a href="/customer/dashboard" class="text-pink-400 font-semibold">Dashboard</a>
                <a href="/customer/antrian" class="text-gray-600 hover:text-pink-400">+ Antrian</a>

                <a href="#"
                    onclick="event.preventDefault(); 
                    if (confirm('Yakin ingin logout?')) {
                        document.getElementById('logout-form').submit();
                    }"
                    class="text-gray-600 hover:text-pink-400">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    {{-- CONTAINER UTAMA --}}
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-12">

        <h2 class="text-3xl font-bold text-gray-800 mb-4">Dashboard Customer</h2>

        {{-- INFORMASI USER --}}
        <div class="bg-white p-6 rounded-xl shadow-sm mb-10">
            <h3 class="text-xl font-bold text-gray-700 mb-2">
                Halo, {{ $nama }} Selamat datang di Photogenic Booth!
            </h3>
            <p class="text-gray-600">
               Buat antrianmu dulu yuk, biar kamu bisa foto tanpa harus nunggu lama
            </p>
        </div>

        {{-- ANTRIAN SAYA --}}
        <div class="bg-white p-8 rounded-xl shadow-sm mb-10">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Antrian Saya</h3>

            @if($antrianku->isEmpty())
                <p class="text-gray-600 text-center py-10">Belum ada antrian yang kamu buat.</p>
            @else
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-pink-200 text-gray-700">
                            <th class="p-3">Nomor</th>
                            <th class="p-3">Paket</th>
                            <th class="p-3">Booth</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($antrianku as $item)
                            <tr class="border-t">
                                <td class="p-3 font-semibold">{{ $item->nomor_antrian }}</td>
                                <td class="p-3">{{ $item->paket->nama_paket ?? '-' }}</td>
                                <td class="p-3">{{ $item->booth->nama_booth ?? '-' }}</td>
                                <td class="p-3">{{ $item->tanggal }}</td>
                                <td class="p-3">
                                    <span class="px-3 py-1 rounded-full text-white
                                        @if($item->status == 'menunggu') bg-yellow-500
                                        @elseif($item->status == 'diproses') bg-blue-500
                                        @else bg-green-500 @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- ANTRIAN PER BOOTH --}}
        <div class="bg-white p-8 rounded-xl shadow-sm mb-10">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Antrian Per Booth</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($booth as $booth)
                    <div class="border rounded-xl p-5 shadow-sm bg-pink-50">

                        <h4 class="text-xl font-bold text-pink-500 mb-3 text-center">
                            {{ $booth->nama_booth }}
                        </h4>

                        @if($booth->antrian->isEmpty())
                            <p class="text-gray-500 italic text-center py-5">Belum ada antrian.</p>
                        @else
                            <div class="space-y-3 max-h-64 overflow-y-auto">

                                @foreach ($booth->antrian as $row)
                                    <div class="p-3 bg-white rounded-lg shadow-sm border">

                                        <p class="font-semibold">
                                            Nomor: {{ $row->nomor_antrian }}

                                            @if($row->pengguna_id == session('customer_id'))
                                                <span class="text-xs bg-green-500 text-white px-2 py-1 rounded">
                                                    (Antrian Kamu)
                                                </span>
                                            @endif
                                        </p>

                                        <p class="text-sm text-gray-600">
                                            Nama: {{ $row->pengguna->nama_pengguna ?? '-' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Paket: {{ $row->paket->nama_paket ?? '-' }}
                                        </p>

                                        <span class="text-xs text-white px-3 py-1 rounded-full
                                            @if($row->status == 'menunggu') bg-yellow-500
                                            @elseif($row->status == 'diproses') bg-blue-500
                                            @else bg-green-500 @endif">
                                            {{ ucfirst($row->status) }}
                                        </span>

                                    </div>
                                @endforeach

                            </div>
                        @endif

                    </div>
                @endforeach

            </div>
        </div>

    </div>

</body>
</html>
