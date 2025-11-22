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

<!-- Bigger Square Card -->
<div class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-[360px] p-6 border border-pink-200">

        <!-- Title -->
        <h2 class="text-center text-lg font-semibold text-pink-500 mb-4">
            Detail Antrian
        </h2>

        <!-- Antrian Number -->
        <div class="text-center mb-4">
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

            <!-- Telepon (always visible) -->
            <div>
                <p class="text-xs text-gray-500">Telepon</p>
                <p class="font-medium text-gray-800">
                    {{ $detail->no_telp ?? $detail->pengguna->no_telp ?? 'Tidak tersedia' }}
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

        <!-- Bigger Images -->
        <div class="flex justify-center gap-4 mt-5">
            <img src="{{ asset('storage/' . $detail->paket->gambar) }}"
                 class="w-24 h-24 rounded-lg object-cover shadow-lg border border-pink-200">

            <img src="{{ asset('storage/' . $detail->booth->gambar) }}"
                 class="w-24 h-24 rounded-lg object-cover shadow-lg border border-pink-200">
        </div>

        <!-- Close button -->
        <div class="text-center mt-5">
            <a href="{{ route('customer.dashboard') }}"
               class="text-sm text-pink-500 font-medium hover:underline">
               Kembali
            </a>
        </div>

    </div>
</div>

</body>
</html>
