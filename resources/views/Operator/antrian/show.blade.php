@extends('Operator.layout')

@section('content')
<h2 class="text-4xl font-extrabold mb-6 text-gray-800 text-center">Detail antrian</h2>

{{-- isi data detail --}}
<div class="bg-white p-6 shadow-md rounded-xl divide-y divide-gray-200">
    <!-- nama customer -->
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Nama Customer</span>
        <span class="text-gray-900">{{ $data->pengguna->nama_pengguna ?? '-' }}</span>
    </div>

    <!-- no telepon -->
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">No. telepon</span>
        <span class="text-gray-900">{{ $data->pengguna->no_telp ?? '-' }}</span>
    </div>

    <!-- booth yang dipilih -->
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Booth</span>
        <span class="text-gray-900">{{ $data->booth->nama_booth }}</span>
    </div>

    <!-- paket yang dipilih -->
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Paket</span>
        <span class="text-gray-900">{{ $data->paket->nama_paket }}</span>
    </div>

    <!-- nomor antrian --> 
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Nomor antrian</span>
        <span class="text-gray-900">{{ $data->nomor_antrian }}</span>
    </div>

    <!-- tanggal dan waktu -->
    <div>
      <label class="block text-gray-700 font-semibold mb-2">Tanggal & Waktu</label>
        <p class="text-gray-600 text-lg italic">
            {{ $data->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}
        </p>
        </div>

    {{-- status antrian saat ini --}}
    <div class="py-3 flex justify-between items-center hover:bg-gray-50 transition">
        <span class="font-medium text-gray-700">Status</span>
        <span class="
        {{
        $data->status === 'menunggu' ? 'text-yellow-500' :
        ($data->status === 'proses' ? 'text-blue-500' :
        ($data->status === 'selesai' ? 'text-green-500' :
        ($data->status === 'batal' ? 'text-gray-500' : 'text-red-500')))
        }}
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

<!-- tombol -->
<a href="{{ route('operator.antrian.index') }}"
   class="mt-6 inline-block px-5 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">
    Kembali
</a>
@endsection
