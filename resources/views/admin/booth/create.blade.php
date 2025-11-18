@extends('admin.layouts.app')

@section('title', 'Tambah Booth')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Tambah Booth</h2>

    <form action="{{ route('admin.booth.store') }}" method="POST">
        @csrf

        <label class="block mb-2">Nama Booth</label>
        <input type="text" name="nama_booth" class="w-full p-2 border rounded-lg mb-4" required>

        <label class="block mb-2">Kapasitas</label>
        <input type="number" name="kapasitas" class="w-full p-2 border rounded-lg mb-4" required>

        <label class="block mb-2">Status</label>
        <select name="status" class="w-full p-2 border rounded-lg mb-4">
            <option value="kosong">Kosong</option>
            <option value="terpakai">Terpakai</option>
        </select>

        <label class="block mb-2">Jam Mulai</label>
        <input type="time" name="jam_mulai" class="w-full p-2 border rounded-lg mb-4">

        <label class="block mb-2">Jam Selesai</label>
        <input type="time" name="jam_selesai" class="w-full p-2 border rounded-lg mb-4">

        <button class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600">
            Simpan
        </button>
    </form>
</div>
@endsection
