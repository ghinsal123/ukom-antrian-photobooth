@extends('Operator.layout')

@section('content')
<h2 class="text-xl font-bold mb-4">Detail Antrian</h2>

<div class="bg-white p-5 shadow rounded">
    <p><strong>Pengguna:</strong> {{ $data->pengguna->nama ?? '-' }}</p>
    <p><strong>Booth:</strong> {{ $data->booth->nama_booth }}</p>
    <p><strong>Paket:</strong> {{ $data->paket->nama_paket }}</p>
    <p><strong>Nomor Antrian:</strong> {{ $data->nomor_antrian }}</p>
    <p><strong>Tanggal:</strong> {{ $data->tanggal }}</p>
    <p><strong>Status:</strong> {{ ucfirst($data->status) }}</p>
    <p><strong>Catatan:</strong> {{ $data->catatan }}</p>
</div>

<a href="{{ route('operator.antrian.index') }}" class="mt-4 inline-block px-4 py-2 bg-gray-300 rounded">Kembali</a>
@endsection
