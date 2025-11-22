<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Antrian</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-400">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center">
                <a href="/customer/dashboard" class="text-gray-600 hover:text-pink-400">Dashboard</a>
                <a href="/customer/antrian" class="text-gray-600 hover:text-pink-400">+ Antrian</a>

                <a href="#"
                    onclick="event.preventDefault(); 
                    if (confirm('Apakah Anda yakin ingin logout?')) {
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

    {{-- FORM WRAPPER --}}
    <div class="max-w-2xl mx-auto px-4 py-6 mt-2">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Form Edit Antrian</h2>

        <div class="bg-white p-6 rounded-xl shadow-sm">

            {{-- FORM --}}
            <form action="{{ route('customer.antrian.update', $antrian->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Nama Lengkap</label>
                        <input 
                            type="text" 
                            class="w-full p-2.5 border rounded-lg bg-gray-50 text-sm"
                            value="{{ $antrian->pengguna->nama_pengguna }}"
                            disabled>
                    </div>

                    {{-- GRID 2 KOLOM --}}
                    <div class="grid grid-cols-2 gap-4">

                        {{-- TELEPON READONLY --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Nomor Telepon</label>
                            <input 
                                type="text"
                                name="no_telp"
                                value="{{ $antrian->pengguna->no_telp }}"
                                class="w-full p-2.5 border rounded-lg bg-gray-100 text-sm cursor-not-allowed"
                                readonly>
                        </div>

                        {{-- TANGGAL READONLY --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Tanggal</label>
                            <input 
                                type="date" 
                                name="tanggal"
                                value="{{ $antrian->tanggal }}" 
                                class="w-full p-2.5 border rounded-lg bg-gray-100 text-sm cursor-not-allowed"
                                readonly>
                        </div>

                    </div>

                    {{-- GRID 2 KOLOM --}}
                    <div class="grid grid-cols-2 gap-4">

                        {{-- PAKET --}}
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1.5 text-sm">Pilih Paket Foto</label>
                            <select 
                                name="paket_id"
                                id="selectPaket"
                                class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm"
                                required>
                                
                                @foreach ($paket as $p)
                                    <option 
                                        value="{{ $p->id }}" 
                                        data-gambar="{{ asset('storage/'.$p->gambar) }}"
                                        {{ $antrian->paket_id == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_paket }}
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
                                class="w-full p-2.5 border rounded-lg focus:ring-pink-300 focus:border-pink-400 text-sm"
                                required>
                                
                                @foreach ($booth as $b)
                                    <option 
                                        value="{{ $b->id }}" 
                                        data-gambar="{{ asset('storage/'.$b->gambar) }}"
                                        {{ $antrian->booth_id == $b->id ? 'selected' : '' }}>
                                        {{ $b->nama_booth }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- PREVIEW --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="border rounded-lg p-3 bg-gray-50 flex justify-center items-center min-h-[120px]">
                            <p id="textPaket" class="text-gray-400 text-xs hidden">Preview Paket</p>
                            <img id="previewPaket" src="{{ asset('storage/' . $antrian->paket->gambar) }}" class="w-full h-28 object-cover rounded-lg">
                        </div>

                        <div class="border rounded-lg p-3 bg-gray-50 flex justify-center items-center min-h-[120px]">
                            <p id="textBooth" class="text-gray-400 text-xs hidden">Preview Booth</p>
                            <img id="previewBooth" src="{{ asset('storage/' . $antrian->booth->gambar) }}" class="w-full h-28 object-cover rounded-lg">
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="pt-2">
                        <button 
                            type="submit"
                            class="w-full bg-pink-400 text-white py-2.5 rounded-lg font-semibold hover:bg-pink-500 transition text-sm">
                            Simpan Perubahan
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        // PREVIEW PAKET
        const selectPaket = document.getElementById('selectPaket');
        const previewPaket = document.getElementById('previewPaket');
        const textPaket = document.getElementById('textPaket');

        selectPaket.addEventListener('change', function () {
            const gambar = this.options[this.selectedIndex].dataset.gambar;
            textPaket.classList.add('hidden');
            previewPaket.src = gambar;
            previewPaket.classList.remove('hidden');
        });

        // PREVIEW BOOTH
        const selectBooth = document.getElementById('selectBooth');
        const previewBooth = document.getElementById('previewBooth');
        const textBooth = document.getElementById('textBooth');

        selectBooth.addEventListener('change', function () {
            const gambar = this.options[this.selectedIndex].dataset.gambar;
            textBooth.classList.add('hidden');
            previewBooth.src = gambar;
            previewBooth.classList.remove('hidden');
        });
    </script>

</body>
</html>
