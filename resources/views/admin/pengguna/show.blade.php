@extends('admin.layouts.app')

@section('title', 'Pengguna')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    {{-- JUDUL HALAMAN --}}
    <h2 class="text-2xl font-semibold text-gray-700 mb-5 text-center">Detail Pengguna</h2>

    {{-- FOTO PENGGUNA (jika ada) --}}
    <div class="flex justify-center">
        @if($pengguna->foto)
            <img src="{{ asset('storage/'.$pengguna->foto) }}" 
                 width="150" class="rounded-xl mb-4">
        @endif
    </div>

    {{-- INFORMASI PENGGUNA --}}
    <div class="space-y-3">
        {{-- Nama pengguna --}}
        <p><strong>Nama:</strong> {{ $pengguna->nama_pengguna }}</p>

        {{-- Nomor telepon --}}
        <p><strong>Telepon:</strong> {{ $pengguna->no_telp }}</p>

        {{-- Role pengguna --}}
        <p><strong>Role:</strong> {{ ucfirst($pengguna->role) }}</p>

        {{-- Tanggal dibuat --}}
        <p><strong>Dibuat:</strong> 
            {{ $pengguna->created_at->format('d M Y H:i') }}
        </p>

        {{-- Tanggal diperbarui --}}
        <p><strong>Diedit:</strong> 
            {{ $pengguna->updated_at->format('d M Y H:i') }}
        </p>
    </div>

    {{-- TOMBOL KEMBALI --}}
    <div class="flex justify-between mt-6">
        <a href="{{ route('admin.pengguna.index') }}"
            class="px-4 py-2 border rounded-xl hover:bg-gray-100">
            Kembali
        </a>
    </div>

</div>
@endsection
