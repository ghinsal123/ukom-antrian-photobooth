@extends('admin.layouts.app')

@section('title', 'Edit Booth')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Booth</h2>

    <form action="{{ route('admin.booth.update', $booth->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label class="block mb-2">Nama Booth</label>
        <input type="text" name="nama_booth" class="w-full p-2 border rounded-lg mb-4"
               value="{{ $booth->nama_booth }}" required>

        <label class="block mb-2">Kapasitas</label>
        <input type="number" name="kapasitas" class="w-full p-2 border rounded-lg mb-4"
               value="{{ $booth->kapasitas }}" required>

        <label class="block mb-2">Gambar Booth</label>
        @if($booth->gambar)
            <img src="{{ asset('storage/' . $booth->gambar) }}" class="w-24 h-24 object-cover rounded-lg mb-3">
        @endif

        <input type="file" name="gambar" accept="image/*"
               class="w-full p-2 border rounded-lg mb-4">

        <button class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">
            Update
        </button>
    </form>
</div>
@endsection
