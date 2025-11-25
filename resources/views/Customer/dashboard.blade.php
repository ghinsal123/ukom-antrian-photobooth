<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Customer</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

    {{-- POPUP SUCCESS --}}
    @if (session('success'))
        <div id="popupSuccess" class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
            <div class="popupContent bg-white p-8 rounded-2xl shadow-xl w-[350px] text-center scale-75 opacity-0 animate-zoomIn">
                <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-full border border-green-400 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-green-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p class="text-lg font-semibold text-gray-700 mb-4">{{ session('success') }}</p>
                <button onclick="document.getElementById('popupSuccess').remove()"
                    class="px-5 py-2 bg-pink-500 text-white rounded-lg shadow hover:bg-pink-600">
                    OK
                </button>
            </div>
        </div>

        <style>
            @keyframes zoomIn {
                0% { transform: scale(0.6); opacity: 0; }
                70% { transform: scale(1.05); opacity: 1; }
                100% { transform: scale(1); opacity: 1; }
            }
            .animate-zoomIn { animation: zoomIn 0.25s ease-out forwards; }
        </style>
    @endif

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-lg sm:text-xl font-bold text-pink-500">PhotoBooth FlashFrame</h1>
            <div class="hidden md:flex gap-6 items-center text-sm">
                <a href="{{ route('customer.dashboard') }}" class="text-pink-500 font-semibold">Dashboard</a>
                <a href="{{ route('customer.antrian') }}" class="text-gray-600 hover:text-pink-500">+ Antrian</a>
                <a href="{{ route('customer.arsip') }}" class="text-gray-600 hover:text-pink-500">Arsip</a>
                <a href="#" onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();"
                    class="text-gray-600 hover:text-pink-500">Logout</a>
                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
            <button class="md:hidden text-2xl text-pink-500" onclick="toggleMenu()">☰</button>
        </div>

        <div id="mobileMenu" class="hidden md:hidden px-4 pb-4 space-y-2">
            <a href="{{ route('customer.dashboard') }}" class="block text-gray-700 hover:text-pink-500">Dashboard</a>
            <a href="{{ route('customer.antrian') }}" class="block text-gray-700 hover:text-pink-500">+ Antrian</a>
            <a href="{{ route('customer.arsip') }}" class="block text-gray-700 hover:text-pink-500">Arsip</a>
            <a href="#" onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();"
                class="block text-gray-700 hover:text-pink-500">Logout</a>
        </div>
    </nav>

    <script>
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
        function openCancelModal(id) {
            document.getElementById('cancelModal-' + id).classList.remove('hidden');
        }
        function closeCancelModal(id) {
            document.getElementById('cancelModal-' + id).classList.add('hidden');
        }
    </script>


    <div class="max-w-6xl mx-auto px-4 py-8 space-y-8">
        <!-- HEADER -->
        <div class="flex justify-between items-center bg-white p-4 shadow-md rounded-lg mb-6">

            <div>
                <h1 class="text-lg font-semibold text-gray-800">
                    Halo, {{ $pengguna->nama_pengguna ?? 'Customer' }}
                </h1>
                <p class="text-sm text-gray-500 -mt-1">
                    Selamat datang di FrameFlash Photobooth!
                </p>
            </div>

            <a href="{{ route('customer.profil.edit') }}" class="block">
                <img src="{{ $pengguna->foto 
                    ? asset('storage/' . $pengguna->foto) 
                    : 'https://ui-avatars.com/api/?name=' . urlencode($pengguna->nama_pengguna) }}"
                    class="w-12 h-12 rounded-full object-cover border-2 border-pink-300 hover:scale-105 transition">
            </a>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- ANTRIAN SAYA -->
            <div class="bg-white p-6 rounded-xl shadow-sm flex flex-col">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Antrian Saya</h3>

                @php
                    $antrianAktif = $antrianku->filter(fn($x) => in_array(strtolower($x->status), ['menunggu','proses','diproses']));
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
                                        <p class="text-sm font-semibold text-pink-600">Nomor Antrian: {{ $item->nomor_antrian }}</p>
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
                                        class="px-3 py-1 text-xs rounded-md bg-blue-100 text-blue-800">Detail</a>

                                    @if ($status == 'menunggu')
                                        <a href="{{ route('customer.antrian.edit', $item->id) }}"
                                            class="px-3 py-1 text-xs rounded-md bg-yellow-100 text-yellow-800">Edit</a>

                                        <button type="button"
                                            onclick="openCancelModal('{{ $item->id }}')"
                                            class="px-3 py-1 text-xs rounded-md bg-red-100 text-red-700">
                                            Batal
                                        </button>

                                        <!-- MODAL -->
                                        <div id="cancelModal-{{ $item->id }}"
                                            class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center">
                                            <div class="bg-white p-6 rounded-xl w-[350px]">
                                                <h3 class="font-semibold text-gray-800 mb-3">
                                                    Batalkan Antrian #{{ $item->nomor_antrian }}
                                                </h3>
                                                <form action="{{ route('customer.antrian.delete', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <label class="block text-sm text-gray-600 mb-1">Catatan pembatalan (Wajib)</label>
                                                    <textarea name="alasan" class="w-full border p-2 rounded mb-3 resize-none" required></textarea>
                                                    <div class="flex justify-end gap-2">
                                                        <button type="button"
                                                            onclick="closeCancelModal('{{ $item->id }}')"
                                                            class="px-3 py-1 text-xs rounded-md bg-gray-200 text-gray-700">Batal</button>

                                                        <button type="submit"
                                                            class="px-3 py-1 text-xs rounded-md bg-red-500 text-white">
                                                            Konfirmasi
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        @endforeach
                    </div>
                @endif
            </div>

            <!-- === ANTRIAN PER BOOTH === -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Antrian Per Booth</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($booth as $bItem)
                        <div class="border p-4 rounded-lg bg-pink-50 h-auto flex flex-col">
                            <h4 class="text-center text-pink-600 font-bold mb-3">{{ $bItem->nama_booth }}</h4>

                            @php
                                $list = $bItem->antrian
                                    ->filter(fn($r) => in_array(strtolower($r->status), ['menunggu','proses','diproses','selesai']))
                                    ->sortBy(fn($q) => strtolower($q->status) === 'selesai' ? 1 : 0);
                            @endphp

                            @if ($list->isEmpty())
                                <p class="text-center text-gray-500 text-sm my-auto">Belum ada antrian.</p>
                            @else
                                <div class="space-y-2 flex-1">
                                    @foreach ($list as $row)
                                        @php
                                            $status = strtolower($row->status);

                                            // wrapper selesai → pink lembut
                                            $wrapperClass =
                                                $status === 'selesai' ? 'bg-pink-100 border-pink-300' :
                                                ($status === 'dibatalkan' ? 'bg-red-200 opacity-50' : 'bg-white');
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
                                                        @elseif($status=='selesai') bg-pink-600 text-white
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
