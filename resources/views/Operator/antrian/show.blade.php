@extends('Operator.layout')

@section('content')
<h2 class="text-4xl font-extrabold mb-6 text-gray-800 text-center">Detail antrian</h2>

<div class="bg-white p-6 shadow-md rounded-xl divide-y divide-gray-200">

    {{-- pengguna --}}
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Pengguna</span>
        <span class="text-gray-900">{{ $data->pengguna->nama_pengguna ?? '-' }}</span>
    </div>

    {{-- nomor telepon --}}
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">No. telp</span>
        <span class="text-gray-900">{{ $data->pengguna->no_telp ?? '-' }}</span>
    </div>

    {{-- booth --}}
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Booth</span>
        <span class="text-gray-900">{{ $data->booth->nama_booth }}</span>
    </div>

    {{-- paket --}}
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Paket</span>
        <span class="text-gray-900">{{ $data->paket->nama_paket }}</span>
    </div>

    {{-- nomor antrian --}}
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Nomor antrian</span>
        <span class="text-gray-900">{{ $data->nomor_antrian }}</span>
    </div>

    {{-- tanggal & waktu --}}
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Tanggal & waktu</span>
        <span class="text-gray-900">
            {{ \Carbon\Carbon::parse($data->tanggal)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
        </span>
    </div>

    {{-- status --}}
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Status</span>
        <span class="
            @if($data->status === 'menunggu') text-yellow-500
            @elseif($data->status === 'proses') text-blue-500
            @elseif($data->status === 'selesai') text-green-500
            @elseif($data->status === 'batal') text-red-500
            @endif
            font-semibold flex items-center gap-2
        ">
            {{ ucfirst($data->status) }}
        </span>
    </div>

    {{-- catatan --}}
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Catatan</span>
        <span class="text-gray-900">{{ $data->catatan ?? '-' }}</span>
    </div>

</div>

<a href="{{ route('operator.antrian.index') }}"
   class="mt-6 inline-block px-5 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
    Kembali
</a>
@endsection
