@extends('Operator.layout')

@section('content')
<h2 class="text-3xl font-bold mb-4">Detail Paket</h2>

<ul class="list-disc ml-5">
    <li>Nama Paket: {{ $paket->nama_paket }}</li>
    <li>Harga: {{ $paket->harga }}</li>
    <li>Deskripsi: {{ $paket->deskripsi ?? '-' }}</li>
    <li>
        Gambar: 
        @if($paket->gambar)
            <img src="{{ asset('storage/' . $paket->gambar) }}" alt="{{ $paket->nama_paket }}" class="w-48 mt-2">
        @else
            -
        @endif
    </li>
</ul>

<a href="{{ route('operator.paket.index') }}" class="mt-4 inline-block text-blue-500">Kembali</a>
@endsection
