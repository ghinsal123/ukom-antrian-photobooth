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
    <nav class="bg-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-pink-500">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center text-sm">
                <a href="{{ route('customer.dashboard') }}" class="text-pink-500 font-semibold">Dashboard</a>

                <a href="{{ route('customer.antrian') }}" class="hover:text-pink-500 text-gray-600">+ Antrian</a>

                <a href="#"
                   onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();"
                   class="hover:text-pink-500 text-gray-600">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <!-- FLASH MESSAGE -->
    <div class="max-w-6xl mx-auto px-4 mt-5">
        @if(session('success'))
            <div class="alert bg-green-100 text-green-700">{{ session('success') }}</div>
        @endif
        @if(session('warning'))
            <div class="alert bg-yellow-100 text-yellow-700">{{ session('warning') }}</div>
        @endif
        @if(session('error'))
            <div class="alert bg-red-100 text-red-700">{{ session('error') }}</div>
        @endif
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">

        <!-- GREETING -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h3 class="text-xl font-semibold text-gray-800">
                Halo, {{ $pengguna->nama_pengguna }}
            </h3>
            <p class="text-gray-500 text-sm mt-1">Selamat datang di FlashFrame Photo Booth.</p>
        </div>

        <!-- ========================== -->
        <!-- TATA LETAK BARU DITUKAR -->
        <!-- ========================== -->

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ========================= -->
            <!-- KOLOM KIRI: ANTRIAN SAYA -->
            <!-- ========================= -->
            <div class="bg-white p-6 rounded-xl shadow-sm h-[380px] flex flex-col">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">Antrian Saya</h3>

                @if ($antrianku->isEmpty())
                    <p class="text-center text-gray-500 py-5">Belum ada antrian.</p>
                @else

                    <div class="space-y-3 overflow-y-auto pr-1">
                        @foreach ($antrianku as $item)
                            <div class="rounded-lg border bg-pink-50 p-4">

                                <!-- INFO -->
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="text-sm font-semibold text-pink-600">
                                            Nomor Antrian: {{ $item->nomor_antrian }}
                                            <span class="inline-block ml-2 w-2 h-2 rounded-full bg-pink-500"></span>
                                        </p>

                                        <p class="text-gray-600 text-xs">Paket: {{ $item->paket->nama_paket }}</p>
                                        <p class="text-gray-600 text-xs">Booth: {{ $item->booth->nama_booth }}</p>
                                        <p class="text-gray-600 text-xs">Tanggal: {{ $item->tanggal }}</p>
                                    </div>

                                    <div class="text-right">
                                        @if($item->status == 'menunggu')
                                            <span class="status-gray">Menunggu</span>
                                        @elseif($item->status == 'diproses')
                                            <span class="status-green">Diproses</span>
                                        @elseif($item->status == 'selesai')
                                            <span class="status-pink">Selesai</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- BUTTONS -->
                                <div class="flex gap-2 mt-2 flex-wrap">
                                    <a href="{{ route('customer.antrian.detail', $item->id) }}" class="btn-mini-blue">Detail</a>

                                    @if ($item->status == 'menunggu')
                                        <a href="{{ route('customer.antrian.edit', $item->id) }}" class="btn-mini-yellow">Edit</a>

                                        <form action="{{ route('customer.antrian.delete', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin membatalkan antrian ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-mini-red">Batal</button>
                                        </form>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>

                @endif
            </div>

            <!-- ============================= -->
            <!-- KOLOM KANAN: ANTRIAN PER BOOTH -->
            <!-- ============================= -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">Antrian Per Booth</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($booth as $bItem)
                        <div class="border p-4 rounded-lg bg-pink-50 h-72 flex flex-col">
                            <h4 class="text-center text-pink-600 font-bold mb-3">{{ $bItem->nama_booth }}</h4>

                            @if ($bItem->antrian->isEmpty())
                                <p class="text-center text-gray-500 text-sm mt-auto mb-auto">Belum ada antrian.</p>
                            @else
                                <div class="space-y-2 overflow-y-auto">
                                    @foreach ($bItem->antrian as $row)
                                        <div class="bg-white border p-3 rounded-lg">
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
                                                    @if($row->status == 'menunggu')
                                                        <span class="status-gray">Menunggu</span>
                                                    @elseif($row->status == 'diproses')
                                                        <span class="status-green">Diproses</span>
                                                    @elseif($row->status == 'selesai')
                                                        <span class="status-pink">Selesai</span>
                                                    @endif
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

    <!-- ========== STYLES ========== -->
    <style>
        .alert { padding: 10px; border-radius: 6px; font-size: 14px; margin-bottom: 10px; }

        /* STATUS COLORS */
        .status-gray { background:#e5e7eb; color:#374151; padding:3px 8px; border-radius:6px; font-size:11px; }
        .status-green { background:#22c55e; color:white; padding:3px 8px; border-radius:6px; font-size:11px; }
        .status-pink { background:#fbcfe8; color:#9d174d; padding:3px 8px; border-radius:6px; font-size:11px; }

        /* MINI BUTTONS */
        .btn-mini-blue {
            background:#dbeafe; color:#1e40af;
            padding:5px 9px; border-radius:6px; font-size:12px;
        }
        .btn-mini-yellow {
            background:#fef9c3; color:#92400e;
            padding:5px 9px; border-radius:6px; font-size:12px;
        }
        .btn-mini-red {
            background:#fee2e2; color:#991b1b;
            padding:5px 9px; border-radius:6px; font-size:12px;
        }

        .btn-mini-blue:hover,
        .btn-mini-yellow:hover,
        .btn-mini-red:hover { opacity:.9; }
    </style>

</body>
</html>
