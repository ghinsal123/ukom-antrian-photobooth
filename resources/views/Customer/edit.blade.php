<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Antrian</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-3 flex flex-col md:flex-row md:justify-between md:items-center gap-3">
            <h1 class="text-2xl font-bold text-pink-400 text-center md:text-left">PhotoBooth FlashFrame</h1>
            <div class="flex gap-6 items-center justify-center md:justify-end">
                <a href="/customer/dashboard" class="text-gray-600 hover:text-pink-400">Dashboard</a>
                <a href="/customer/antrian" class="text-gray-600 hover:text-pink-400">+ Antrian</a>
                <a href="#" onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin logout?')) { document.getElementById('logout-form').submit(); }" class="text-gray-600 hover:text-pink-400">Logout</a>
                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </div>
    </nav>

    <div class="max-w-xl mx-auto px-4 py-6 mt-2">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Form Edit Antrian</h2>
        <div class="bg-white p-6 rounded-xl shadow-sm">

            <form action="{{ route('customer.antrian.update', $antrian->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">

                    <div>
                        <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Nama Lengkap</label>
                        <input type="text" class="w-full p-2.5 border rounded-lg bg-gray-50 text-sm" value="{{ $antrian->pengguna->nama_pengguna }}" disabled>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Nomor Telepon</label>
                            <input type="text" name="no_telp" value="{{ $antrian->pengguna->no_telp }}" class="w-full p-2.5 border rounded-lg bg-gray-100 text-sm cursor-not-allowed" readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ $antrian->tanggal }}" class="w-full p-2.5 border rounded-lg bg-gray-100 text-sm cursor-not-allowed" readonly>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Pilih Paket Foto</label>
                            <select name="paket_id" id="selectPaket" class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm" required>
                                @foreach ($paket as $p)
                                <option 
                                    value="{{ $p->id }}" 
                                    data-gambar="{{ asset('storage/'.$p->gambar) }}" 
                                    data-deskripsi="{{ $p->deskripsi }}" 
                                    data-harga="{{ $p->harga }}"
                                    {{ $antrian->paket_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_paket }} - Rp{{ number_format($p->harga, 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Pilih Booth</label>
                            <select name="booth_id" id="selectBooth" class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm" required>
                                @foreach ($booth as $b)
                                <option 
                                    value="{{ $b->id }}" 
                                    data-gambar="{{ asset('storage/'.$b->gambar) }}" 
                                    data-deskripsi="{{ $b->deskripsi }}"
                                    data-kapasitas="{{ $b->kapasitas }}"
                                    {{ $antrian->booth_id == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama_booth }} (Maks {{ $b->kapasitas }} orang)
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- PREVIEW -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Paket -->
                        <div class="border rounded-lg p-3 bg-gray-50">
                            <p class="text-sm font-semibold text-pink-500 mb-2">Paket</p>
                            <img id="previewPaket" src="{{ asset('storage/' . $antrian->paket->gambar) }}" class="w-full h-32 object-cover rounded-lg mb-2">

                            <p id="deskripsiPaket" class="text-xs text-gray-600">{{ $antrian->paket->deskripsi }}</p>

                            <p id="hargaPaket" class="text-xs font-semibold text-pink-600 mt-1">
                                Rp{{ number_format($antrian->paket->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Booth -->
                        <div class="border rounded-lg p-3 bg-gray-50">
                            <p class="text-sm font-semibold text-purple-500 mb-2">Booth</p>
                            <img id="previewBooth" src="{{ asset('storage/' . $antrian->booth->gambar) }}" class="w-full h-32 object-cover rounded-lg mb-2">

                            <p id="deskripsiBooth" class="text-xs text-gray-600">{{ $antrian->booth->deskripsi }}</p>

                            <p id="kapasitasBooth" class="text-xs font-semibold text-purple-600 mt-1">
                                Maks: {{ $antrian->booth->kapasitas }} orang
                            </p>
                        </div>

                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-pink-400 text-white py-2.5 rounded-lg font-semibold hover:bg-pink-500 transition text-sm">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const selectPaket = document.getElementById('selectPaket');
        const previewPaket = document.getElementById('previewPaket');
        const deskripsiPaket = document.getElementById('deskripsiPaket');
        const hargaPaket = document.getElementById('hargaPaket');

        selectPaket.addEventListener('change', function () {
            const s = this.options[this.selectedIndex];
            previewPaket.src = s.dataset.gambar;
            deskripsiPaket.textContent = s.dataset.deskripsi || '';
            hargaPaket.textContent = "Rp" + new Intl.NumberFormat('id-ID').format(s.dataset.harga);
        });

        const selectBooth = document.getElementById('selectBooth');
        const previewBooth = document.getElementById('previewBooth');
        const deskripsiBooth = document.getElementById('deskripsiBooth');
        const kapasitasBooth = document.getElementById('kapasitasBooth');

        selectBooth.addEventListener('change', function () {
            const s = this.options[this.selectedIndex];
            previewBooth.src = s.dataset.gambar;
            deskripsiBooth.textContent = s.dataset.deskripsi || '';
            kapasitasBooth.textContent = "Maks: " + s.dataset.kapasitas + " orang";
        });
    </script>

</body>
</html>
