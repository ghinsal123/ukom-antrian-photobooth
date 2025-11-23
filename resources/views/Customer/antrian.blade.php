<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Antrian</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

    <!-- NAVBAR – versi dashboard -->
    <nav class="bg-white shadow-md sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-lg sm:text-xl font-bold text-pink-500">
                PhotoBooth FlashFrame
            </h1>

            <div class="hidden md:flex gap-6 items-center text-sm">
                <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-pink-500">Dashboard</a>

                <!-- ACTIVE PAGE -->
                <a href="{{ route('customer.antrian') }}" class="text-pink-500 font-semibold">+ Antrian</a>

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

        <!-- MOBILE MENU -->
        <div id="mobileMenu" class="hidden md:hidden px-4 pb-4 space-y-2">
            <a href="{{ route('customer.dashboard') }}" class="block text-gray-700 hover:text-pink-500">Dashboard</a>
            <a href="{{ route('customer.antrian') }}" class="block text-pink-500 font-semibold">+ Antrian</a>
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

    <!-- FORM WRAPPER -->
    <div class="max-w-3xl mx-auto px-4 py-8 mt-2">

        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4">Form Tambah Antrian</h2>

        <div class="bg-white p-6 rounded-xl shadow-sm">

            <!-- ERROR ALERT -->
            @if($errors->any())
                <div class="mb-4 p-3 rounded border border-red-300 bg-red-100 text-sm text-red-700">
                    <strong>Ada kesalahan:</strong>
                    <ul class="mt-1 list-disc ml-5">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- FORM -->
            <form action="{{ route('customer.antrian.store') }}" method="POST">
                @csrf

                <div class="space-y-4">

                    <!-- NAMA -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Nama Lengkap</label>
                        <input type="text"
                               value="{{ $pengguna->nama_pengguna }}"
                               readonly
                               class="w-full p-2.5 border rounded-lg bg-gray-100 text-gray-600 text-sm">
                    </div>

                    <!-- NOMOR TELEPON -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Nomor Telepon</label>
                        <input type="text"
                               name="no_telp"
                               value="{{ old('no_telp', $pengguna->no_telp) }}"
                               required minlength="10" maxlength="15"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm"
                               placeholder="Masukkan nomor aktif">
                    </div>

                    <!-- GRID PILIHAN -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <!-- TANGGAL -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Tanggal</label>
                            <input type="date"
                                   name="tanggal"
                                   id="tanggalInput"
                                   readonly
                                   class="w-full p-2.5 border rounded-lg bg-gray-100 text-gray-600 text-sm">
                        </div>

                        <!-- PAKET -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Pilih Paket Foto</label>
                            <select name="paket_id" id="selectPaket" required
                                    class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm">
                                <option disabled selected>Pilih paket</option>

                                @foreach ($paket as $p)
                                    <option value="{{ $p->id }}"
                                            data-gambar="{{ asset('storage/'.$p->gambar) }}"
                                            data-deskripsi="{{ $p->deskripsi }}"
                                            data-harga="{{ $p->harga }}">
                                        {{ $p->nama_paket }} — Rp{{ number_format($p->harga) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- BOOTH -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Pilih Booth</label>
                            <select name="booth_id" id="selectBooth" required
                                    class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm">
                                <option disabled selected>Pilih booth</option>

                                @foreach ($booth as $b)
                                    <option value="{{ $b->id }}"
                                            data-gambar="{{ asset('storage/'.$b->gambar) }}"
                                            data-max="{{ $b->kapasitas }}">
                                        {{ $b->nama_booth }} — Max {{ $b->kapasitas }} orang
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <!-- PREVIEW SECTION -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Preview Paket -->
                        <div class="border rounded-lg p-3 bg-gray-50 min-h-[260px]">
                            <p id="textPaket" class="text-gray-400 text-xs">Preview Paket</p>
                            <img id="previewPaket"
                                 class="w-full h-48 object-cover rounded-lg hidden"
                                 alt="Preview Paket" />
                            <p id="hargaPaket" class="text-sm font-semibold text-pink-500 mt-2 hidden"></p>
                            <p id="deskripsiPaket" class="text-xs text-gray-600 mt-1 hidden"></p>
                        </div>

                        <!-- Preview Booth -->
                        <div class="border rounded-lg p-3 bg-gray-50 min-h-[260px]">
                            <p id="textBooth" class="text-gray-400 text-xs">Preview Booth</p>
                            <img id="previewBooth"
                                 class="w-full h-48 object-cover rounded-lg hidden"
                                 alt="Preview Booth" />
                            <p id="maxBooth" class="text-sm font-semibold text-gray-700 mt-2 hidden"></p>
                        </div>

                    </div>

                    <!-- SUBMIT -->
                    <button type="submit"
                            class="w-full bg-pink-500 text-white py-2.5 rounded-lg font-semibold hover:bg-pink-600 transition text-sm">
                        Tambah Antrian
                    </button>

                </div>
            </form>

        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        // Toggle menu
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }

        // Auto set tanggal hari ini
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();
            today.setMinutes(today.getMinutes() - today.getTimezoneOffset());
            document.getElementById("tanggalInput").value = today.toISOString().slice(0, 10);
        });

        // Preview paket
        document.getElementById('selectPaket')?.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('textPaket').classList.add('hidden');

            const img = document.getElementById('previewPaket');
            img.src = selected.dataset.gambar;
            img.classList.remove('hidden');

            const harga = document.getElementById('hargaPaket');
            harga.innerText = "Harga: Rp " + selected.dataset.harga;
            harga.classList.remove('hidden');

            const desc = document.getElementById('deskripsiPaket');
            desc.innerText = selected.dataset.deskripsi;
            desc.classList.remove('hidden');
        });

        // Preview booth
        document.getElementById('selectBooth')?.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('textBooth').classList.add('hidden');

            const img = document.getElementById('previewBooth');
            img.src = selected.dataset.gambar;
            img.classList.remove('hidden');

            const max = document.getElementById('maxBooth');
            max.innerText = "Kapasitas Booth: " + selected.dataset.max + " orang";
            max.classList.remove('hidden');
        });
    </script>

</body>
</html>
