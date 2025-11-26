<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Antrian</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">

<!-- bg popup -->
<div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40"></div>

<!-- Popup card -->
<div class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl w-[420px] p-6 border border-pink-200">

        <!-- Judul -->
        <h2 class="text-center text-lg font-semibold text-pink-500 mb-4">
            Detail Antrian
        </h2>

        <!-- Nomor Antrian -->
        <div class="text-center mb-4">
            <p class="text-xs text-gray-500">Nomor Antrian</p>
            <p class="text-3xl font-bold text-purple-600">{{ $detail->nomor_antrian }}</p>
        </div>

        <!-- Detail User -->
        <div class="grid grid-cols-2 gap-4 text-sm">

            <div>
                <p class="text-xs text-gray-500">Nama</p>
                <p class="font-medium text-gray-800">{{ $detail->pengguna->nama_pengguna }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Telepon</p>
                <p class="font-medium text-gray-800">
                    {{ $detail->no_telp ?? $detail->pengguna->no_telp ?? 'Tidak tersedia' }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Paket</p>
                <p class="font-medium text-gray-800">{{ $detail->paket->nama_paket }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Tanggal</p>
                <p class="font-medium text-gray-800">{{ $detail->tanggal }}</p>
            </div>

            <div>
                <p class="text-xs text-gray-500">Booth</p>
                <p class="font-medium text-gray-800">{{ $detail->booth->nama_booth }}</p>
            </div>

            <!-- STATUS -->
            <div>
                <p class="text-xs text-gray-500">Status</p>

                @php $status = strtolower($detail->status); @endphp

                @if($status == 'menunggu')
                    <span class="px-2 py-1 bg-gray-200 text-gray-700 text-xs font-medium rounded-md">
                        Menunggu
                    </span>

                @elseif($status == 'proses' || $status == 'diproses')
                    <span class="px-2 py-1 bg-green-500 text-white text-xs font-medium rounded-md">
                        Diproses
                    </span>

                @elseif($status == 'selesai')
                    <span class="px-2 py-1 bg-pink-200 text-pink-800 text-xs font-medium rounded-md">
                        Selesai
                    </span>

                @elseif($status == 'dibatalkan')
                    <span class="px-2 py-1 bg-red-200 text-red-800 text-xs font-medium rounded-md">
                        Dibatalkan
                    </span>
                @endif
            </div>

        </div>

        <!-- Preview Paket & Booth -->
        <div class="grid grid-cols-2 gap-6 mt-6">

            <!-- Paket -->
            <div class="flex flex-col items-center">
                <p class="text-sm font-medium text-pink-500 mb-1">Paket</p>

                <div class="w-28 h-28 rounded-lg overflow-hidden border border-pink-200 shadow-md">
                    <img src="{{ asset('storage/' . $detail->paket->gambar) }}" class="w-full h-full object-cover">
                </div>

                @if(!empty($detail->paket->deskripsi))
                    <p class="text-xs text-gray-600 mt-2 text-center">
                        {{ $detail->paket->deskripsi }}
                    </p>
                @endif

                <p class="text-xs font-semibold text-pink-600 mt-1">
                    Rp{{ number_format($detail->paket->harga, 0, ',', '.') }}
                </p>
            </div>

            <!-- Booth -->
            <div class="flex flex-col items-center">
                <p class="text-sm font-medium text-purple-500 mb-1">Booth</p>

                <div class="w-28 h-28 rounded-lg overflow-hidden border border-pink-200 shadow-md">
                    <img src="{{ asset('storage/' . $detail->booth->gambar) }}" class="w-full h-full object-cover">
                </div>

                @if(!empty($detail->booth->deskripsi))
                <p class="text-xs text-gray-600 mt-2 text-center">
                    {{ $detail->booth->deskripsi }}
                </p>
                @endif

                <p class="text-xs font-semibold text-purple-600 mt-1">
                    Maks: {{ $detail->booth->kapasitas }} orang
                </p>
            </div>

        </div>

        <!-- Tombol kembali -->
        <div class="text-center mt-6">
            <a href="{{ route('customer.dashboard') }}"
               class="text-sm text-pink-500 font-medium hover:underline">
               Kembali
            </a>
        </div>

    </div>
</div>

</body>
</html>
