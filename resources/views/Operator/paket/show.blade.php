@extends('Operator.layout')

@section('content')
<h2 class="text-xl font-bold mb-4">{{ $paket->nama_paket }}</h2>

<div class="bg-white p-5 shadow rounded">
    @if($paket->gambar)
    <img src="{{ asset('storage/' . $paket->gambar) }}" class="w-40 mb-3">
    @endif

    <p><strong>Harga:</strong> Rp {{ number_format($paket->harga, 0, ',', '.') }}</p>
    <p><strong>Deskripsi:</strong> {{ $paket->deskripsi }}</p>
</div>

<a href="/operator/paket" class="mt-4 inline-block px-4 py-2 bg-gray-300 rounded">Kembali</a>
@endsection
