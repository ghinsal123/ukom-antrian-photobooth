@extends('admin.layouts.app')

@section('title', 'Paket')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    <h2 class="text-2xl font-semibold text-gray-700 mb-5 text-center">Detail Paket</h2>

    <div class="flex justify-center">
        @if($paket->gambar)
            <img src="{{ asset('storage/'.$paket->gambar) }}" width="250" class="rounded-xl mb-4">
        @endif
    </div>
    
    <div class="space-y-3">
        <p><strong>Nama Paket:</strong> {{ $paket->nama_paket }}</p>
        <p><strong>Harga:</strong> Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
        <p><strong>Deskripsi:</strong> {{ $paket->deskripsi }}</p>
        <p><strong>Dibuat:</strong> {{ $paket->created_at ? $paket->created_at->format('d M Y H:i') : '-' }}</p>
        <p><strong>Diedit:</strong> {{ $paket->updated_at ? $paket->updated_at->format('d M Y H:i') : '-' }}</p>
    </div>

    <div class="flex justify-between mt-6">
        <a href="{{ route('admin.paket.index') }}"
            class="px-4 py-2 border rounded-xl hover:bg-gray-100">
            Kembali
        </a>
    </div>

</div>
@endsection