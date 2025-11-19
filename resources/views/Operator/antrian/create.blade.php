@extends('Operator.layout')

@section('content')
<h2 class="text-3xl font-bold mb-4 text-gray-800">Tambah Antrian</h2>

<form action="{{ route('operator.antrian.store') }}" method="POST" class="bg-white p-5 shadow rounded max-w-lg">
    @csrf

    {{-- Nama Customer --}}
    <div class="mb-4">
        <label class="font-semibold">Nama Customer</label>
        <input type="text" name="nama_pengguna" placeholder="Ketik nama customer..." 
               class="w-full border p-2 rounded" required>
    </div>

    {{-- Pilih Booth --}}
    <div class="mb-4">
        <label class="font-semibold">Booth</label>
        <select name="booth_id" class="w-full border p-2 rounded" required>
            @foreach ($booth as $b)
                <option value="{{ $b->id }}">{{ $b->nama_booth }}</option>
            @endforeach
        </select>
    </div>

    {{-- Pilih Paket --}}
    <div class="mb-4">
        <label class="font-semibold">Paket</label>
        <select name="paket_id" class="w-full border p-2 rounded" required>
            @foreach ($paket as $p)
                <option value="{{ $p->id }}">{{ $p->nama_paket }}</option>
            @endforeach
        </select>
    </div>

    {{-- Tanggal --}}
    <div class="mb-4">
        <label class="font-semibold">Tanggal</label>
        <input type="date" name="tanggal" class="w-full border p-2 rounded" required>
    </div>

    {{-- Catatan --}}
    <div class="mb-4">
        <label class="font-semibold">Catatan</label>
        <textarea name="catatan" class="w-full border p-2 rounded" placeholder="Opsional"></textarea>
    </div>

    <button class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600 transition">
        Simpan Antrian
    </button>
</form>
@endsection
