@extends('admin.layouts.app')

@section('title', 'Edit Booth')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Booth</h2>

    <form action="{{ route('admin.booth.update', $booth->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2">Nama Booth</label>
        <input type="text" name="nama_booth" class="w-full p-2 border rounded-lg mb-4"
               value="{{ $booth->nama_booth }}" required>

        <label class="block mb-2">Kapasitas</label>
        <input type="number" name="kapasitas" class="w-full p-2 border rounded-lg mb-4"
               value="{{ $booth->kapasitas }}" required>

        <label class="block mb-2">Status</label>
        <select name="status" class="w-full p-2 border rounded-lg mb-4">
            <option value="kosong" {{ $booth->status == 'kosong' ? 'selected' : '' }}>Kosong</option>
            <option value="terpakai" {{ $booth->status == 'terpakai' ? 'selected' : '' }}>Terpakai</option>
        </select>

        <label class="block mb-2">Jam Mulai</label>
        <input type="time" name="jam_mulai" class="w-full p-2 border rounded-lg mb-4"
               value="{{ $booth->jam_mulai }}">

        <label class="block mb-2">Jam Selesai</label>
        <input type="time" name="jam_selesai" class="w-full p-2 border rounded-lg mb-4"
               value="{{ $booth->jam_selesai }}">

        <button class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">
            Update
        </button>
    </form>
</div>
@endsection
