<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Form Antrian</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">

            <h1 class="text-xl md:text-2xl font-bold text-pink-400">
                PhotoBooth FlashFrame
            </h1>

            <div class="hidden md:flex gap-6 items-center">
                <a href="/customer/dashboard" class="text-gray-600 hover:text-pink-400">Dashboard</a>
                <a href="/customer/antrian" class="text-pink-400 font-semibold">+ Antrian</a>

                <a href="#"
                    onclick="event.preventDefault();
                    if (confirm('Apakah Anda yakin ingin logout?')) {
                        document.getElementById('logout-form').submit();
                    }"
                    class="text-gray-600 hover:text-pink-400">Logout</a>

                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>

            <button onclick="toggleMenu()" class="md:hidden text-pink-400 text-2xl font-bold">☰</button>
        </div>

        {{-- MENU MOBILE --}}
        <div id="mobileMenu" class="hidden md:hidden px-4 pb-3 space-y-2">
            <a href="/customer/dashboard" class="block text-gray-600 hover:text-pink-400">Dashboard</a>
            <a href="/customer/antrian" class="block text-pink-400 font-semibold">+ Antrian</a>
            <a href="#"
                onclick="event.preventDefault();
                if (confirm('Yakin mau logout?')) {
                    document.getElementById('logout-form').submit();
                }"
                class="block text-gray-600 hover:text-pink-400">Logout</a>
        </div>
    </nav>


    {{-- FORM WRAPPER --}}
    <div class="max-w-3xl mx-auto px-4 py-6 mt-6">
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4">Form Tambah Antrian</h2>

        <div class="bg-white p-6 rounded-xl shadow-sm">

            {{-- ALERT ERROR --}}
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

            {{-- FORM --}}
            <form action="{{ route('customer.antrian.store') }}" method="POST">
                @csrf

                <div class="space-y-4">

                    {{-- NAMA USER --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Nama Lengkap</label>
                        <input
                            type="text"
                            value="{{ $pengguna->nama_pengguna }}"
                            readonly
                            class="w-full p-2.5 border rounded-lg bg-gray-100 text-gray-600 text-sm">
                    </div>

                    {{-- NOMOR HP --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Nomor Telepon</label>
                        <input
                            type="text"
                            name="no_telp"
                            value="{{ old('no_telp', $pengguna->no_telp) }}"
                            required
                            minlength="10"
                            maxlength="15"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm"
                            placeholder="Masukkan nomor telepon aktif kamu">
                    </div>

                    {{-- GRID PILIHAN --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        {{-- TANGGAL AUTO --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Tanggal</label>
                            <input
                                type="date"
                                name="tanggal"
                                id="tanggalInput"
                                readonly
                                class="w-full p-2.5 border rounded-lg bg-gray-100 text-gray-600 text-sm">
                        </div>

                        {{-- PAKET --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Pilih Paket Foto</label>
                            <select
                                name="paket_id"
                                id="selectPaket"
                                required
                                class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm">
                                <option value="" disabled selected>Pilih paket</option>

                                @foreach ($paket as $p)
                                    <option value="{{ $p->id }}"
                                        data-gambar="{{ asset('storage/'.$p->gambar) }}"
                                        data-deskripsi="{{ $p->deskripsi }}"
                                        data-harga="{{ $p->harga }}">
                                        {{ $p->nama_paket }} — Rp{{ number_format($p->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- BOOTH --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Pilih Booth</label>
                            <select
                                name="booth_id"
                                id="selectBooth"
                                required
                                class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm">
                                <option value="" disabled selected>Pilih booth</option>

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

                    {{-- PREVIEW --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- PREVIEW PAKET --}}
                        <div class="border rounded-lg p-3 bg-gray-50 min-h-[260px]">
                            <p id="textPaket" class="text-gray-400 text-xs">Preview Paket</p>

                            <img id="previewPaket" class="w-full h-48 object-cover rounded-lg hidden" alt="">

                            <p id="hargaPaket" class="text-sm font-semibold text-pink-500 mt-2 hidden"></p>

                            <p id="deskripsiPaket" class="text-xs text-gray-600 mt-1 hidden"></p>
                        </div>

                        {{-- PREVIEW BOOTH --}}
                        <div class="border rounded-lg p-3 bg-gray-50 min-h-[260px]">
                            <p id="textBooth" class="text-gray-400 text-xs">Preview Booth</p>

                            <img id="previewBooth" class="w-full h-48 object-cover rounded-lg hidden" alt="">

                            <p id="maxBooth" class="text-sm font-semibold text-gray-700 mt-2 hidden"></p>
                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <button
                        type="submit"
                        class="w-full bg-pink-400 text-white py-2.5 rounded-lg font-semibold hover:bg-pink-500 transition text-sm">
                        Tambah Antrian
                    </button>

                </div>
            </form>
        </div>
    </div>


    {{-- SCRIPT PREVIEW + FIX TANGGAL OTOMATIS --}}
    <script>
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }

        // === FIX TANGGAL OTOMATIS 100% AKURAT ===
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();
            today.setMinutes(today.getMinutes() - today.getTimezoneOffset());
            document.getElementById("tanggalInput").value = today.toISOString().slice(0, 10);
        });

        const sP = document.getElementById('selectPaket');
        const sB = document.getElementById('selectBooth');

        // preview paket
        sP?.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];

            document.getElementById('textPaket').classList.add('hidden');

            const prev = document.getElementById('previewPaket');
            prev.src = selected.dataset.gambar;
            prev.classList.remove('hidden');

            const price = document.getElementById('hargaPaket');
            price.innerText = "Harga: Rp " + selected.dataset.harga;
            price.classList.remove('hidden');

            const desc = document.getElementById('deskripsiPaket');
            desc.innerText = selected.dataset.deskripsi;
            desc.classList.remove('hidden');
        });

        // preview booth
        sB?.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];

            document.getElementById('textBooth').classList.add('hidden');

            const prev = document.getElementById('previewBooth');
            prev.src = selected.dataset.gambar;
            prev.classList.remove('hidden');

            const maxBox = document.getElementById('maxBooth');
            maxBox.innerText = "Kapasitas Booth: " + selected.dataset.max + " orang";
            maxBox.classList.remove('hidden');
        });
    </script>

</body>
</html>
