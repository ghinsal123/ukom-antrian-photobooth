@extends('Operator.layout')

@section('content')
<div class="bg-white rounded-3xl shadow-2xl p-6 max-w-3xl mx-auto mt-8">
    <h2 class="text-3xl font-bold mb-6 text-pink-600">{{ $booth->nama_booth }}</h2>

    <div class="flex justify-center mb-6">
        @if($booth->gambar)
            <img src="{{ asset('storage/' . $booth->gambar) }}" 
                alt="{{ $booth->nama_booth }}" 
                class="w-64 h-64 object-cover rounded-xl shadow-md">
        @else
            <div class="w-64 h-64 bg-gray-100 flex items-center justify-center rounded-xl shadow-md">
                <span class="text-gray-400 italic">Tidak ada gambar</span>
            </div>
        @endif
    </div>

    <div class="text-lg font-semibold text-gray-700 mb-2">
        Kapasitas: <span class="text-pink-500">{{ $booth->kapasitas }}</span>
    </div>

    <!-- WAKTU DIBUAT & DIUPDATE -->
    <div class="text-sm text-gray-500 mb-4">
        Dibuat: {{ $booth->created_at->format('d M Y, H:i') }} <br>
        Terakhir diupdate: {{ $booth->updated_at->format('d M Y, H:i') }}
    </div>

    <a href="{{ route('operator.booth.index') }}" 
       class="inline-block mt-4 bg-pink-500 text-white px-6 py-2 rounded-xl hover:bg-pink-600 shadow-lg transition-all">
       Kembali
    </a>
</div>
@endsection
