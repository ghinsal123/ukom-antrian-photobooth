<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Antrian</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

<!-- Background Blur -->
<div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40"></div>

<!-- Center Card -->
<div class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg max-w-xs w-full relative p-5">

        <!-- Close -->
        <a href="{{ route('customer.dashboard') }}"
           class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </a>

        <!-- Title -->
        <h2 class="text-center text-lg font-semibold text-gray-800 mb-3">Detail Reservasi</h2>

        <!-- Antrian -->
        <div class="text-center mb-3">
            <p class="text-xs text-gray-500">Nomor Antrian</p>
            <p class="text-3xl font-bold text-purple-600">{{ $detail->nomor_antrian }}</p>
        </div>

        <!-- Details -->
        <div class="space-y-3 text-sm">

            <!-- Nama -->
            <div>
                <p class="text-xs text-gray-500">Nama</p>
                <p class="font-medium text-gray-800">{{ $detail->pengguna->nama_pengguna }}</p>
            </div>

            <!-- Telepon -->
            <div>
                <p class="text-xs text-gray-500">Telepon</p>
                <p class="font-medium text-gray-800">
                    {{ $detail->no_telp ?? 'Tidak tersedia' }}
                </p>
            </div>

            <!-- Paket -->
            <div>
                <p class="text-xs text-gray-500">Paket</p>
                <p class="font-medium text-gray-800">{{ $detail->paket->nama_paket }}</p>
            </div>

            <!-- Tanggal -->
            <div>
                <p class="text-xs text-gray-500">Tanggal</p>
                <p class="font-medium text-gray-800">{{ $detail->tanggal }}</p>
            </div>

            <!-- Booth -->
            <div>
                <p class="text-xs text-gray-500">Booth</p>
                <p class="font-medium text-gray-800">{{ $detail->booth->nama_booth }}</p>
            </div>

            <!-- Status -->
            <div>
                <p class="text-xs text-gray-500">Status</p>
                <span class="px-2 py-1 rounded text-xs font-medium
                    {{ $detail->status == 'menunggu' ? 'bg-yellow-100 text-yellow-700' :
                       ($detail->status == 'diproses' ? 'bg-blue-100 text-blue-700' :
                       ($detail->status == 'selesai' ? 'bg-green-100 text-green-700' :
                       'bg-red-100 text-red-700')) }}">
                    {{ ucfirst($detail->status) }}
                </span>
            </div>

        </div>

        <!-- Images -->
        <div class="flex justify-center gap-5 mt-4">
            <img src="{{ asset('storage/' . $detail->paket->gambar) }}"
                 class="w-16 h-16 rounded-lg object-cover shadow">

            <img src="{{ asset('storage/' . $detail->booth->gambar) }}"
                 class="w-16 h-16 rounded-lg object-cover shadow">
        </div>

    </div>
</div>

</body>
</html>
