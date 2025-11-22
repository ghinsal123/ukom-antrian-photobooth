@extends('Operator.layout')

@section('content')
<h2 class="text-2xl font-bold mb-6 text-gray-800">Detail Antrian</h2>

<div class="bg-white p-6 shadow-md rounded-xl divide-y divide-gray-200">
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Pengguna</span>
        <span class="text-gray-900">{{ $data->pengguna->nama_pengguna ?? '-' }}</span>
    </div>
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">No. Telp</span>
        <span class="text-gray-900">{{ $data->pengguna->no_telp ?? '-' }}</span>
    </div>
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Booth</span>
        <span class="text-gray-900">{{ $data->booth->nama_booth }}</span>
    </div>
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Paket</span>
        <span class="text-gray-900">{{ $data->paket->nama_paket }}</span>
    </div>
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Nomor Antrian</span>
        <span class="text-gray-900">{{ $data->nomor_antrian }}</span>
    </div>
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Tanggal</span>
        <span class="text-gray-900">{{ $data->tanggal }}</span>
    </div>
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Status</span>
        <span class="@if($data->status == 'menunggu') text-yellow-500
                    @elseif($data->status == 'proses') text-blue-500
                    @elseif($data->status == 'selesai') text-green-500
                    @elseif($data->status == 'batal') text-red-500
                    @endif font-semibold flex items-center gap-2">
            <!-- Ikon status -->
            @if($data->status == 'menunggu') 
            @elseif($data->status == 'proses') 
            @elseif($data->status == 'selesai') 
            @elseif($data->status == 'batal') 
            @endif
            {{ ucfirst($data->status) }}
        </span>
    </div>
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Catatan</span>
        <span class="text-gray-900">{{ $data->catatan ?? '-' }}</span>
    </div>
</div>

<a href="{{ route('operator.antrian.index') }}" class="mt-6 inline-block px-5 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
    Kembali
</a>
@endsection
