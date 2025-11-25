@extends('Operator.layout')

@section('content')

{{-- judul halaman --}}
<h2 class="text-4xl font-extrabold mb-6 text-gray-800 text-center">detail paket</h2>

{{-- container utama --}}
<div class="max-w-xl mx-auto bg-white p-6 rounded-2xl shadow-lg">

    {{-- gambar paket --}}
    <div class="flex justify-center mb-6">
        @if($paket->gambar)
            <img 
                src="{{ asset('storage/' . $paket->gambar) }}" 
                alt="{{ $paket->nama_paket }}" 
                class="w-64 h-full object-cover rounded-xl shadow-md"
            >
        @else
            <div class="w-64 h-64 flex items-center justify-center bg-gray-100 text-gray-400 rounded-xl">
                tidak ada gambar
            </div>
        @endif
    </div>

    {{-- detail informasi paket --}}
    <div class="space-y-3 text-gray-700">

        {{-- nama paket --}}
        <h2 class="text-2xl font-bold text-pink-600">
            {{ $paket->nama_paket }}
        </h2>

        {{-- harga paket --}}
        <p class="text-lg font-semibold">
            harga: Rp {{ number_format($paket->harga, 0, ',', '.') }}
        </p>

        {{-- deskripsi --}}
        <p>
            deskripsi: {{ $paket->deskripsi ?? '-' }}
        </p>

        {{-- informasi waktu --}}
        <p class="text-sm text-gray-500">
            dibuat: {{ $paket->created_at->format('d M Y, H:i') }} <br>
            terakhir diupdate: {{ $paket->updated_at->format('d M Y, H:i') }}
        </p>

    </div>

    {{-- tombol kembali --}}
    <div class="mt-6">
        <a 
            href="{{ route('operator.paket.index') }}" 
            class="inline-block px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600 shadow"
        >
            kembali
        </a>
    </div>

</div>

@endsection
