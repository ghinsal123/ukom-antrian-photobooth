<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-400">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center">
                <a href="{{ route('customer.dashboard') }}" class="text-pink-400 font-semibold">Dashboard</a>
                <a href="{{ route('customer.antrian') }}" class="text-gray-600 hover:text-pink-400">+ Antrian</a>

                <a href="#"
                   onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();"
                   class="text-gray-600 hover:text-pink-400">Logout</a>

                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <!-- FLASH MESSAGE SIMPLE -->
    <div class="max-w-6xl mx-auto px-4 mt-5">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-4 p-3 bg-yellow-100 border border-yellow-300 text-yellow-700 rounded text-sm">
                {{ session('warning') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded text-sm">
                {{ session('error') }}
            </div>
        @endif

    </div>

    <!-- CONTAINER UTAMA -->
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">

        <!-- HELLO USER -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
                Halo, {{ $pengguna->nama_pengguna }}!
            </h3>
            <p class="text-gray-600 text-sm">Selamat datang di Photogenic Booth.</p>
        </div>

        <!-- ANTRIAN SAYA -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Antrian Saya</h3>

            @if ($antrianku->isEmpty())
                <p class="text-gray-600 text-center py-5 text-sm">Belum ada antrian.</p>
            @else
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-pink-200 text-gray-700">
                            <th class="p-3">Nomor</th>
                            <th class="p-3">Paket</th>
                            <th class="p-3">Booth</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-center">Aksi</th>
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
                                    <span class="px-3 py-1 rounded text-white
                                        @if($item->status == 'menunggu') bg-yellow-500
                                        @elseif($item->status == 'diproses') bg-blue-500
                                        @else bg-green-500 @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>

                                <td class="p-3 text-center">

                                    <a href="{{ route('customer.antrian.detail', $item->id) }}"
                                       class="bg-blue-500 text-white px-3 py-1 rounded text-xs mr-1">
                                        Detail
                                    </a>

                                    @if ($item->status == 'menunggu')
                                        <a href="{{ route('customer.antrian.edit', $item->id) }}"
                                           class="bg-yellow-500 text-white px-3 py-1 rounded text-xs mr-1">
                                            Edit
                                        </a>

                                        <form action="{{ route('customer.antrian.delete', $item->id) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin membatalkan antrian ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-500 text-white px-3 py-1 rounded text-xs">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- ANTRIAN PER BOOTH -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Antrian Per Booth</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($booth as $bItem)
                    <div class="border rounded-xl p-4 bg-pink-50">

                        <h4 class="text-lg font-bold text-pink-500 mb-3 text-center">
                            {{ $bItem->nama_booth }}
                        </h4>

                        @if ($bItem->antrian->isEmpty())
                            <p class="text-gray-500 text-center text-sm py-3">Belum ada antrian.</p>
                        @else
                            <div class="space-y-2 max-h-64 overflow-y-auto">

                                @foreach ($bItem->antrian as $row)
                                    <div class="p-3 bg-white border rounded">

                                        <p class="font-semibold text-sm">
                                            Nomor: {{ $row->nomor_antrian }}

                                            @if ($row->pengguna_id == session('customer_id'))
                                                <span class="text-xs bg-green-500 text-white px-2 py-0.5 rounded">
                                                    Kamu
                                                </span>
                                            @endif
                                        </p>

                                        <p class="text-xs text-gray-600">Nama: {{ $row->pengguna->nama_pengguna ?? '-' }}</p>
                                        <p class="text-xs text-gray-600">Paket: {{ $row->paket->nama_paket ?? '-' }}</p>

                                        <span class="text-xs text-white px-2 py-1 rounded
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
