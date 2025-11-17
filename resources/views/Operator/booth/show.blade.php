@extends('Operator.layout')

@section('content')
<h2 class="text-3xl font-bold mb-4">Detail Booth</h2>

<ul class="list-disc ml-5">
    <li>Nama Booth: {{ $booth->nama_booth }}</li>
    <li>Kapasitas: {{ $booth->kapasitas }}</li>
    <li>Status: {{ $booth->status }}</li>
    <li>Jam Mulai: {{ $booth->jam_mulai ?? '-' }}</li>
    <li>Jam Selesai: {{ $booth->jam_selesai ?? '-' }}</li>
</ul>

<a href="{{ route('operator.booth.index') }}" class="mt-4 inline-block text-blue-500">Kembali</a>
@endsection
