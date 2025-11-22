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
            <h1 class="text-2xl font-bold text-pink-400">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center">
                <a href="/customer/dashboard" class="text-gray-600 hover:text-pink-400">Dashboard</a>
                <a href="/customer/antrian" class="text-pink-400 font-semibold">+ Antrian</a>

                <a href="#"
                    onclick="event.preventDefault();
                    if (confirm('Apakah Anda yakin ingin logout?')) {
                        document.getElementById('logout-form').submit();
                    }"
                    class="text-gray-600 hover:text-ppink-400">Logout</a>

                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    {{-- FORM WRAPPER --}}
    <div class="max-w-3xl mx-auto px-4 py-6 mt-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Form Tambah Antrian</h2>

        <div class="bg-white p-6 rounded-xl shadow-sm">

            {{-- ALERT ERROR SIMPLE --}}
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

                    {{-- NAMA USER OTOMATIS --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Nama Lengkap</label>
                        <input
                            type="text"
                            name="nama_lengkap"
                            value="{{ $pengguna->nama_pengguna }}"
                            readonly
                            class="w-full p-2.5 border rounded-lg bg-gray-100 text-gray-600 text-sm">
                    </div>

                    {{-- NOMOR TELEPON OTOMATIS + HANYA ANGKA --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Nomor Telepon</label>
                        <input
                            type="text"
                            name="no_telp"
                            value="{{ old('no_telp', $pengguna->no_telp) }}"
                            required
                            class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm"
                            placeholder="Masukkan nomor telepon aktif kamu">
                    </div>

                    {{-- TANGGAL - PAKET - BOOTH --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Tanggal</label>
                            <input
                            type="text"
                            name="tanggal"
                            value="{{ date('Y-m-d') }}"
                            readonly
                            class="w-full p-2.5 border rounded-lg bg-gray-100 text-gray-600 text-sm cursor-not-allowed">

                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Pilih Paket Foto</label>
                            <select
                                name="paket_id"
                                id="selectPaket"
                                required
                                class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm">
                                <option value="" disabled selected>Silakan pilih paket</option>
                                @foreach ($paket as $p)
                                    <option value="{{ $p->id }}" data-gambar="{{ asset('storage/'.$p->gambar) }}">
                                        {{ $p->nama_paket }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Pilih Booth</label>
                            <select
                                name="booth_id"
                                id="selectBooth"
                                required
                                class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm">
                                <option value="" disabled selected>Silakan pilih booth</option>
                                @foreach ($booth as $b)
                                    <option value="{{ $b->id }}" data-gambar="{{ asset('storage/'.$b->gambar) }}">
                                        {{ $b->nama_booth }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- PREVIEW GAMBAR (DIBESARKAN) --}}
                    <div class="grid grid-cols-2 gap-4">

                        <div class="border rounded-lg p-3 bg-gray-50 flex justify-center items-center min-h-[200px]">
                            <p id="textPaket" class="text-gray-400 text-xs">Preview Paket</p>
                            <img id="previewPaket" class="w-full h-48 object-cover rounded-lg hidden" alt="">
                        </div>

                        <div class="border rounded-lg p-3 bg-gray-50 flex justify-center items-center min-h-[200px]">
                            <p id="textBooth" class="text-gray-400 text-xs">Preview Booth</p>
                            <img id="previewBooth" class="w-full h-48 object-cover rounded-lg hidden" alt="">
                        </div>

                    </div>

                    {{-- BUTTON SUBMIT --}}
                    <button
                        type="submit"
                        class="w-full bg-pink-400 text-white py-2.5 rounded-lg font-semibold hover:bg-pink-500 transition text-sm">
                        Tambah Antrian
                    </button>

                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT PREVIEW --}}
    <script>
        const sP = document.getElementById('selectPaket');
        const sB = document.getElementById('selectBooth');

        // PREVIEW PAKET
        if (sP) {
            sP.addEventListener('change', function () {
                const img = this.options[this.selectedIndex].dataset.gambar;
                document.getElementById('textPaket').classList.add('hidden');
                const prev = document.getElementById('previewPaket');
                prev.src = img;
                prev.classList.remove('hidden');
            });
        }

        // PREVIEW BOOTH
        if (sB) {
            sB.addEventListener('change', function () {
                const img = this.options[this.selectedIndex].dataset.gambar;
                document.getElementById('textBooth').classList.add('hidden');
                const prev = document.getElementById('previewBooth');
                prev.src = img;
                prev.classList.remove('hidden');
            });
        }
    </script>

</body>
</html>
