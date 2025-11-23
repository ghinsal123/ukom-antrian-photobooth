<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Customer</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-lg sm:text-xl font-bold text-pink-500">
                PhotoBooth FlashFrame
            </h1>

            <div class="hidden md:flex gap-6 items-center text-sm">
                <a href="{{ route('customer.dashboard') }}" class="text-pink-500 font-semibold">Dashboard</a>

                <a href="{{ route('customer.antrian') }}" class="text-gray-600 hover:text-pink-500">+ Antrian</a>

                <a href="{{ route('customer.arsip') }}" class="text-gray-600 hover:text-pink-500">Arsip</a>

                <a href="#"
                   onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();"
                   class="text-gray-600 hover:text-pink-500">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>

            <button class="md:hidden text-2xl text-pink-500" onclick="toggleMenu()">☰</button>
        </div>

        <div id="mobileMenu" class="hidden md:hidden px-4 pb-4 space-y-2">
            <a href="{{ route('customer.dashboard') }}" class="block text-gray-700 hover:text-pink-500">Dashboard</a>
            <a href="{{ route('customer.antrian') }}" class="block text-gray-700 hover:text-pink-500">+ Antrian</a>
            <a href="{{ route('customer.arsip') }}" class="block text-gray-700 hover:text-pink-500">Arsip</a>
            <a href="#"
               onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();"
               class="block text-gray-700 hover:text-pink-500">
                Logout
            </a>
        </div>
    </nav>

    <script>
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
    </script>

    <div class="max-w-6xl mx-auto px-4 py-8 space-y-8">

        <!-- SAPAAN -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h3 class="text-lg sm:text-xl font-semibold text-gray-800">
                Halo, {{ $pengguna->nama_pengguna }}
            </h3>
            <p class="text-gray-500 text-sm mt-1">Selamat datang di FlashFrame Photo Booth.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ANTRIAN SAYA -->
            <div class="bg-white p-6 rounded-xl shadow-sm flex flex-col">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Antrian Saya</h3>

                @php
                    $antrianAktif = $antrianku->filter(function($x) {
                        return in_array(strtolower($x->status), ['menunggu','proses','diproses']);
                    });
                @endphp

                @if ($antrianAktif->isEmpty())
                    <p class="text-center text-gray-500 py-5">Belum ada antrian aktif.</p>
                @else
                    <div class="space-y-3 flex-1">
                        @foreach ($antrianAktif as $item)
                            @php $status = strtolower($item->status); @endphp

                            <div class="rounded-lg border bg-pink-50 p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="text-sm font-semibold text-pink-600">
                                            Nomor Antrian: {{ $item->nomor_antrian }}
                                        </p>
                                        <p class="text-gray-600 text-xs">Paket: {{ $item->paket->nama_paket }}</p>
                                        <p class="text-gray-600 text-xs">Booth: {{ $item->booth->nama_booth }}</p>
                                        <p class="text-gray-600 text-xs">Tanggal: {{ $item->tanggal }}</p>
                                    </div>

                                    <div class="text-right">
                                        @if($status == 'menunggu')
                                            <span class="px-2 py-0.5 bg-gray-200 text-gray-700 text-[11px] rounded-md">Menunggu</span>
                                        @elseif($status == 'proses' || $status == 'diproses')
                                            <span class="px-2 py-0.5 bg-green-500 text-white text-[11px] rounded-md">Diproses</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex gap-2 mt-2 flex-wrap">
                                    <a href="{{ route('customer.antrian.detail', $item->id) }}"
                                       class="px-3 py-1 text-xs rounded-md bg-blue-100 text-blue-800">
                                        Detail
                                    </a>

                                    @if ($status == 'menunggu')
                                        <a href="{{ route('customer.antrian.edit', $item->id) }}"
                                           class="px-3 py-1 text-xs rounded-md bg-yellow-100 text-yellow-800">
                                            Edit
                                        </a>

                                        <form action="{{ route('customer.antrian.delete', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin membatalkan antrian ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 text-xs rounded-md bg-red-100 text-red-700">
                                                Batal
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                        @endforeach
                    </div>
                @endif
            </div>

            <!-- ANTRIAN PER BOOTH -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Antrian Per Booth</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($booth as $bItem)

                        <div class="border p-4 rounded-lg bg-pink-50 h-auto flex flex-col">
                            <h4 class="text-center text-pink-600 font-bold mb-3">{{ $bItem->nama_booth }}</h4>

                            @php
                                $list = $bItem->antrian->filter(function($r) {
                                    return in_array(strtolower($r->status), [
                                        'menunggu','proses','diproses','selesai','dibatalkan'
                                    ]);
                                });
                            @endphp

                            @if ($list->isEmpty())
                                <p class="text-center text-gray-500 text-sm my-auto">Belum ada antrian.</p>
                            @else
                                <div class="space-y-2 flex-1">

                                    @foreach ($list as $row)
                                        @php
                                            $status = strtolower($row->status);

                                            // TANPA TERNARY BERTUMPUK → AMAN PHP 8
                                            if ($status === 'selesai') {
                                                $wrapperClass = 'opacity-50 bg-gray-200';
                                            } elseif ($status === 'dibatalkan') {
                                                $wrapperClass = 'opacity-50 bg-red-200';
                                            } else {
                                                $wrapperClass = 'bg-white';
                                            }
                                        @endphp

                                        <div class="border p-3 rounded-lg {{ $wrapperClass }}">
                                            <div class="flex justify-between items-start">

                                                <div>
                                                    <p class="text-sm font-semibold">
                                                        #{{ $row->nomor_antrian }}

                                                        @if ($row->pengguna_id == session('customer_id'))
                                                            <span class="inline-block ml-2 w-2 h-2 rounded-full bg-pink-500"></span>
                                                        @endif
                                                    </p>

                                                    <p class="text-xs text-gray-600">Paket: {{ $row->paket->nama_paket }}</p>
                                                    <p class="text-xs text-gray-600">Nama: {{ $row->pengguna->nama_pengguna }}</p>
                                                </div>

                                                <div>
                                                    <span class="px-2 py-0.5 text-[11px] rounded-md
                                                        @if($status=='menunggu') bg-gray-200 text-gray-700
                                                        @elseif($status=='proses'||$status=='diproses') bg-green-500 text-white
                                                        @elseif($status=='selesai') bg-gray-500 text-white
                                                        @else bg-red-600 text-white
                                                        @endif">
                                                        {{ ucfirst($row->status) }}
                                                    </span>
                                                </div>

                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                            @endif
                        </div>

                    @endforeach
                </div>
            </div>

        </div>
    </div>

</body>
</html>
