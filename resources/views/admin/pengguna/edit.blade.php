@extends('admin.layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    <h2 class="text-2xl font-semibold text-gray-700 mb-5">Edit Pengguna</h2>

    @if ($errors->any())
        <div class="bg-red-200 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pengguna.update', $pengguna) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- NAMA --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nama Pengguna</label>
            <input type="text" name="nama_pengguna" required
                class="w-full p-2 border rounded-xl"
                value="{{ old('nama_pengguna', $pengguna->nama_pengguna) }}">
        </div>

        {{-- TELEPON --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Nomor Telepon</label>
            <input type="text" name="no_telp" required
                class="w-full p-2 border rounded-xl"
                value="{{ old('no_telp', $pengguna->no_telp) }}">
        </div>

        {{-- PASSWORD --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Password (isi jika ingin ubah)</label>
            <input type="password" name="password"
                class="w-full p-2 border rounded-xl">
        </div>

        {{-- FOTO --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Foto</label>
            <input type="file" name="foto" accept="image/*"
                class="w-full p-2 border rounded-xl">
        </div>

        @if($pengguna->foto)
            <div class="mb-4">
                <p class="font-medium">Foto Saat Ini:</p>
                <img src="{{ asset('storage/'.$pengguna->foto) }}" width="120" class="rounded-xl mt-2">
            </div>
        @endif

        {{-- ROLE KHUSUS OPERATOR --}}
        @if($pengguna->role === 'operator')
        <div class="mb-4">
            <label class="block mb-1 font-medium">Role</label>

            <input type="text"
                class="w-full p-2 border rounded-xl bg-gray-100 text-gray-600"
                value="Operator"
                disabled>

            <input type="hidden" name="role" value="operator">
        </div>
        @endif

        {{-- ROLE ADMIN DISIMPAN TANPA INPUT --}}
        @if($pengguna->role === 'admin')
            <input type="hidden" name="role" value="admin">
        @endif

        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.pengguna.index') }}"
               class="px-4 py-2 border rounded-xl hover:bg-gray-100">
                Batal
            </a>

            <button type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 shadow">
                Perbarui
            </button>
        </div>

    </form>
</div>
@endsection
