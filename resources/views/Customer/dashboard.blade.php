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

    <div class="max-w-6xl mx-auto px-4 py-10">

        <h2 class="text-3xl font-bold text-gray-800 mb-8">Dashboard Customer</h2>

        {{-- INFORMASI USER --}}
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
            <h3 class="text-xl font-bold text-gray-700 mb-2">Halo, {{ $nama }} 👋</h3>
            <p class="text-gray-600">Berikut antrian kamu dan daftar antrian pada tiap booth.</p>
        </div>


        {{-- ===========================
              1️⃣  ANTRIAN SAYA
        ============================ --}}
        <div class="bg-white p-8 rounded-xl shadow-sm mb-12">
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



        {{-- ===========================
              2️⃣  ANTRIAN PER BOOTH
        ============================ --}}
        <div class="bg-white p-8 rounded-xl shadow-sm">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Antrian Per Booth</h3>

            @foreach ($booths as $booth)
                <div class="mb-10">
                    <h4 class="text-xl font-bold text-pink-500 mb-3">{{ $booth->nama_booth }}</h4>

                    @if($antrianBooth[$booth->id]->isEmpty())
                        <p class="text-gray-500 italic">Belum ada antrian di booth ini.</p>
                    @else
                        <table class="w-full text-left border-collapse mb-6">
                            <thead>
                                <tr class="bg-gray-200 text-gray-700">
                                    <th class="p-3">Nomor</th>
                                    <th class="p-3">Nama Pengguna</th>
                                    <th class="p-3">Paket</th>
                                    <th class="p-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($antrianBooth[$booth->id] as $row)
                                    <tr class="border-t">
                                        <td class="p-3 font-semibold">{{ $row->nomor_antrian }}</td>
                                        <td class="p-3">{{ $row->pengguna->nama_pengguna ?? '-' }}</td>
                                        <td class="p-3">{{ $row->paket->nama_paket ?? '-' }}</td>
                                        <td class="p-3">
                                            <span class="px-3 py-1 rounded-full text-white 
                                                @if($row->status == 'menunggu') bg-yellow-500
                                                @elseif($row->status == 'diproses') bg-blue-500
                                                @else bg-green-500
                                                @endif">
                                                {{ ucfirst($row->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            @endforeach
        </div>

    </div>

</body>
</html>
