<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Antrian</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">

            <h1 class="text-xl md:text-2xl font-bold text-pink-400">
                PhotoBooth FlashFrame
            </h1>

            <div class="hidden md:flex gap-6 items-center">
                <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-pink-400">Dashboard</a>

                <a href="{{ route('customer.antrian') }}" class="text-gray-600 hover:text-pink-400">
                    + Antrian
                </a>

                <a href="{{ route('customer.arsip') }}" class="text-pink-400 font-bold">Arsip</a>

                <a href="#"
                    onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();"
                    class="text-gray-600 hover:text-pink-400">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>

            <button onclick="toggleMenu()" class="md:hidden text-pink-400 text-2xl font-bold">☰</button>
        </div>

        <div id="mobileMenu" class="hidden md:hidden px-4 pb-3 space-y-2">
            <a href="{{ route('customer.dashboard') }}" class="block text-gray-700 hover:text-pink-400">Dashboard</a>
            <a href="{{ route('customer.antrian') }}" class="block text-gray-700 hover:text-pink-400">+ Antrian</a>
            <a href="{{ route('customer.arsip') }}" class="block text-pink-400 font-semibold">Arsip</a>
            <a href="#"
                onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();"
                class="block text-gray-700 hover:text-pink-400">
                Logout
            </a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-6 mt-6">

        <h2 class="text-xl font-bold text-gray-800">Arsip Antrian</h2>

        <p class="text-sm text-gray-600 mb-4">
            {{ $pengguna->nama }} — {{ now()->format('d M Y') }}
        </p>



        @if ($arsip->isEmpty())

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <p class="text-yellow-700 text-sm">Belum ada antrian yang selesai atau dibatalkan.</p>
            </div>

        @else

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">

            <table class="min-w-full text-sm">
                <thead class="bg-pink-400 text-white">
                    <tr class="text-center">
                        <th class="py-3 px-2">No</th>
                        <th class="py-3 px-2">Nomor Antrian</th>
                        <th class="py-3 px-2">Paket</th>
                        <th class="py-3 px-2">Booth</th>
                        <th class="py-3 px-2">Status</th>
                        <th class="py-3 px-2">Catatan Operator</th>
                        <th class="py-3 px-2">Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($arsip as $item)
                    <tr class="border-b text-center hover:bg-gray-50">

                        <td class="py-3 px-2">{{ $loop->iteration }}</td>

                        <td class="py-3 px-2 font-semibold">
                            {{ $item->nomor_antrian }}
                        </td>

                        <td class="py-3 px-2">
                            {{ $item->paket->nama_paket }}
                        </td>

                        <td class="py-3 px-2">
                            {{ $item->booth->nama_booth }}
                        </td>

                        <td class="py-3 px-2">
                            @if ($item->status === 'selesai')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-xs">Selesai</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded text-xs">Dibatalkan</span>
                            @endif
                        </td>

                        <td class="py-3 px-2">
                            {{ $item->catatan ?? '-' }}
                        </td>

                        <td class="py-3 px-2">
                            {{ date('d M Y', strtotime($item->tanggal)) }}
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        @endif

    </div>

    <script>
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
    </script>

</body>
</html>
