@extends('Operator.layout')

@section('content')
<h2 class="text-xl font-bold mb-4">Detail Reservasi</h2>

<div class="bg-white p-5 shadow rounded">
    <p><strong>Paket:</strong> {{ $data->paket->nama_paket }}</p>
    <p><strong>Tanggal:</strong> {{ $data->tanggal }}</p>
    <p><strong>Status:</strong> {{ ucfirst($data->status) }}</p>
    <p><strong>Catatan:</strong> {{ $data->catatan }}</p>
</div>

<a href="/operator/reservasi" class="mt-4 inline-block px-4 py-2 bg-gray-300 rounded">Kembali</a>
@endsection
