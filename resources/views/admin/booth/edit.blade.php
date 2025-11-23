@extends('admin.layouts.app')

@section('title', 'Edit Booth')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    {{-- POPUP ERROR --}}
    @if ($errors->any())
    <div id="popupError" class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">

        <div class="bg-white w-[350px] p-7 rounded-2xl shadow-xl text-center animate-popup">

            {{-- ICON --}}
            <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-full border border-red-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <p class="text-xl font-semibold text-gray-800 mb-1">Gagal!</p>

            <p class="text-gray-600 mb-4">
                Terjadi kesalahan pada input. <br>
                <span class="font-semibold">{{ $errors->first() }}</span>
            </p>

            <button onclick="document.getElementById('popupError').remove()"
                class="px-5 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">
                Mengerti
            </button>

        </div>
    </div>

    <style>
        @keyframes popup {
            0% { transform: scale(0.6); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-popup { animation: popup 0.25s ease-out; }
    </style>
    @endif

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

        <div class="flex justify-between mt-6">
            <a href="{{ route('admin.booth.index') }}"
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