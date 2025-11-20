<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Antrian</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-400">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center">
                <a href="/customer/dashboard" class="text-gray-600 hover:text-pink-400">Dashboard</a>
                <a href="/customer/antrian" class="text-pink-400 font-semibold">+ Antrian</a>

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



    {{-- CONTAINER --}}
    <div class="max-w-xl mx-auto bg-white mt-10 p-8 rounded-xl shadow">

        <h2 class="text-3xl font-bold text-gray-800 mb-6">Buat Antrian Baru</h2>

        <form action="{{ route('customer.antrian.store') }}" method="POST">
            @csrf

            <label class="block mb-2 font-semibold text-gray-700">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="w-full p-3 border rounded-lg mb-4 bg-pink-50">

            <label class="block mb-2 font-semibold text-gray-700">No Telepon</label>
            <input type="text" name="no_telp" class="w-full p-3 border rounded-lg mb-4 bg-pink-50">

            <label class="block mb-2 font-semibold text-gray-700">Pilih Booth</label>
            <select name="booth_id" class="w-full p-3 border rounded-lg mb-4 bg-pink-50">
                @foreach ($booths as $b)
                    <option value="{{ $b->id }}">{{ $b->nama_booth }}</option>
                @endforeach
            </select>

            <label class="block mb-2 font-semibold text-gray-700">Pilih Paket</label>
            <select name="paket_id" class="w-full p-3 border rounded-lg mb-4 bg-pink-50">
                @foreach ($pakets as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_paket }}</option>
                @endforeach
            </select>

            <label class="block mb-2 font-semibold text-gray-700">Tanggal</label>
            <input type="date" name="tanggal" class="w-full p-3 border rounded-lg mb-6 bg-pink-50">

            <button class="w-full bg-pink-500 text-white py-3 rounded-lg font-semibold shadow hover:bg-pink-600 transition">
                Buat Antrian
            </button>
        </form>

    </div>

</body>
</html>
