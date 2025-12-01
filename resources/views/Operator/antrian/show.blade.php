@extends('Operator.layout')

@section('content')
<h2 class="text-4xl font-extrabold mb-6 text-gray-800 text-center">Tiket Antrian</h2>

<div class="bg-white p-6 shadow-md rounded-xl divide-y divide-gray-200">

    <!-- Info Customer -->
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Nama Customer</span>
        <span class="text-gray-900">{{ $data->pengguna->nama_pengguna ?? '-' }}</span>
    </div>
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">No. Telepon</span>
        <span class="text-gray-900">+62{{ $data->pengguna->no_telp ?? '-' }}</span>
    </div>

    <!-- Booth & Paket -->
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Booth</span>
        <span class="text-gray-900">{{ $data->booth->nama_booth }}</span>
    </div>
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Paket</span>
        <span class="text-gray-900">{{ $data->paket->nama_paket }}</span>
    </div>

    <!-- Nomor Antrian & Waktu -->
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Nomor Tiket</span>
        <span class="text-gray-900">{{ str_pad($data->nomor_antrian, 3, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Tanggal & Waktu</span>
        <span class="text-gray-900">{{ $data->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</span>
    </div>

    <!-- Status -->
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Status</span>
        @php
            $statusClass = match($data->status) {
                'menunggu' => 'text-yellow-500',
                'proses' => 'text-blue-500',
                'selesai' => 'text-green-500',
                'batal', 'expired' => 'text-gray-500',
                default => 'text-red-500',
            };
        @endphp
        <span class="{{ $statusClass }} font-semibold">{{ ucfirst($data->status) }}</span>
    </div>

    <!-- Catatan -->
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Catatan</span>
        <span class="text-gray-900">{{ $data->catatan ?? '-' }}</span>
    </div>

    <!-- Barcode & Expired in One Row -->
    @if(!empty($barcodeImageBase64) || ($data->status == 'menunggu' && $data->expired_at))
    <div class="flex items-center justify-between mt-2">

    <!-- Barcode kiri -->
    @if(!empty($barcodeImageBase64))
        <div class="shrink-0">
            <img src="{{ $barcodeImageBase64 }}" alt="Barcode" class="w-50">
        </div>
    @endif

    <!-- Expired kanan -->
    @if($data->status == 'menunggu' && $data->expired_at)
        <div class="text-right ml-3">
            <p class="text-xs text-red-500 leading-tight">
                Kadaluarsa: 
            </p>
            <span class="text-sm font-bold text-red-600">
                {{ \Carbon\Carbon::parse($data->expired_at)->format('H:i') }} 
            </span>
        </div>
    @endif

</div>
@endif

    <!-- Scan Barcode Form -->
    @if($data->status == 'menunggu')
    <form action="{{ route('operator.antrian.scan') }}" method="POST" class="mt-4 flex justify-center">
        @csrf
        <input type="text" name="barcode" placeholder="Scan barcode..." class="border px-3 py-2 rounded-l-lg">
        <button type="submit" class="bg-blue-500 text-white px-4 rounded-r-lg hover:bg-blue-600">Konfirmasi</button>
    </form>
    @endif

    <!-- Tombol Complete Manual -->
    @if($data->status == 'proses')
    <form action="{{ route('operator.antrian.complete', $data->id) }}" method="POST" class="mt-4 text-center">
        @csrf
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Tandai Selesai
        </button>
    </form>
    @endif

</div>

<a href="{{ route('operator.antrian.index') }}"
   class="mt-6 inline-block px-5 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
    Kembali
</a>
@endsection
