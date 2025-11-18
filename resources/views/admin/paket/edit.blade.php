@extends('admin.layouts.app')

@section('title', 'Edit Paket')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Paket</h2>

    <form action="{{ route('admin.paket.update', $paket->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label class="block mb-2">Nama Paket</label>
        <input type="text" name="nama_paket" value="{{ $paket->nama_paket }}" class="w-full p-2 border rounded-lg mb-4" required>

        <label class="block mb-2">Harga</label>
        <input type="number" name="harga" value="{{ $paket->harga }}" class="w-full p-2 border rounded-lg mb-4" required>

        <label class="block mb-2">Gambar</label>
        @if($paket->gambar)
            <img src="{{ asset('storage/'.$paket->gambar) }}" class="w-20 mb-2 rounded-lg">
        @endif
        <input type="file" name="gambar" class="w-full p-2 border rounded-lg mb-4">

        <label class="block mb-2">Deskripsi</label>
        <textarea name="deskripsi" class="w-full p-2 border rounded-lg mb-4">{{ $paket->deskripsi }}</textarea>

        <button class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">
            Update
        </button>
    </form>

</div>
@endsection
