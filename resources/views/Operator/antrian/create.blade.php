@extends('Operator.layout')

@section('content')
<h2 class="text-xl font-bold mb-4">Tambah Antrian</h2>

<form action="{{ route('operator.antrian.store') }}" method="POST" class="bg-white p-5 shadow rounded">
    @csrf

    {{-- Pilih Pengguna --}}
    <div class="mb-3">
        <label class="font-semibold">Pengguna</label>
        <select name="pengguna_id" class="w-full border p-2 rounded">
            @foreach ($pengguna as $p)
                <option value="{{ $p->id }}">{{ $p->nama }}</option>
            @endforeach
        </select>
    </div>

    {{-- Pilih Booth --}}
    <div class="mb-3">
        <label class="font-semibold">Booth</label>
        <select name="booth_id" class="w-full border p-2 rounded">
            @foreach ($booth as $b)
                <option value="{{ $b->id }}">{{ $b->nama_booth }}</option>
            @endforeach
        </select>
    </div>

    {{-- Pilih Paket --}}
    <div class="mb-3">
        <label class="font-semibold">Paket</label>
        <select name="paket_id" class="w-full border p-2 rounded">
            @foreach ($paket as $p)
                <option value="{{ $p->id }}">{{ $p->nama_paket }}</option>
            @endforeach
        </select>
    </div>

    {{-- Tanggal --}}
    <div class="mb-3">
        <label class="font-semibold">Tanggal</label>
        <input type="date" name="tanggal" class="w-full border p-2 rounded">
    </div>

    {{-- Catatan --}}
    <div class="mb-3">
        <label class="font-semibold">Catatan</label>
        <textarea name="catatan" class="w-full border p-2 rounded"></textarea>
    </div>

    <button class="bg-pink-500 text-white px-4 py-2 rounded">Simpan</button>
</form>
@endsection
