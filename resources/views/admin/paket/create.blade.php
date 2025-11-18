@extends('admin.layouts.app')

@section('title', 'Tambah Paket')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Tambah Paket</h2>

    <form action="{{ route('admin.paket.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label class="block mb-2">Nama Paket</label>
        <input type="text" name="nama_paket" class="w-full p-2 border rounded-lg mb-4" required>

        <label class="block mb-2">Harga</label>
        <input type="number" name="harga" class="w-full p-2 border rounded-lg mb-4" required>

        <label class="block mb-2">Gambar</label>
        <input type="file" name="gambar" class="w-full p-2 border rounded-lg mb-4">

        <label class="block mb-2">Deskripsi</label>
        <textarea name="deskripsi" class="w-full p-2 border rounded-lg mb-4"></textarea>

        <button class="px-4 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600">
            Simpan
        </button>
    </form>

</div>
@endsection
