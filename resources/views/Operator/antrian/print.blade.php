@extends('Operator.layout')

@section('content')
<h2 class="text-xl font-bold mb-4">Cetak Reservasi</h2>

<div class="bg-white p-6 shadow rounded">
    <p>Nama: Putri</p>
    <p>Paket: Gold</p>
    <p>Status: Menunggu</p>

    <button onclick="window.print()" class="mt-4 bg-pink-500 text-white px-4 py-2 rounded">
        Print
    </button>
</div>
@endsection
