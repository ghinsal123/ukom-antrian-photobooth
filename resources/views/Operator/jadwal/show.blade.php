@extends('Operator.layout')

@section('content')
<h2 class="text-xl font-bold mb-4">Detail Jadwal</h2>

<div class="bg-white p-5 shadow rounded">
    <p><strong>Booth:</strong> {{ $jadwal->booth }}</p>
    <p><strong>Tanggal:</strong> {{ $jadwal->tanggal }}</p>
    <p><strong>Status:</strong> {{ ucfirst($jadwal->status) }}</p>
</div>

<a href="/operator/jadwal" class="mt-4 inline-block px-4 py-2 bg-gray-300 rounded">Kembali</a>
@endsection
