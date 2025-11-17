@extends('Operator.layout')

@section('content')
<div class="container">

    <h2 class="text-2xl font-bold mb-4">Detail Jadwal</h2>

    <div class="bg-white p-4 rounded shadow-md">
        <p><strong>Tanggal:</strong> {{ $jadwal->tanggal }}</p>
        <p><strong>Nomor Antrian:</strong> {{ $jadwal->nomor_antrian }}</p>
        <p><strong>Status:</strong> {{ ucfirst($jadwal->status) }}</p>
        <p><strong>Catatan:</strong> {{ $jadwal->catatan ?? '-' }}</p>

        <br>

        <a href="{{ route('jadwal.index') }}" class="text-blue-600 font-semibold">← Kembali</a>
    </div>

</div>
@endsection
