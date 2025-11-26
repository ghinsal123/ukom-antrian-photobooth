@extends('admin.layouts.app')

@section('title', 'Booth')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    <h2 class="text-2xl font-semibold text-gray-700 mb-4 text-center pb-2">Detail Booth</h2>

    {{-- Gambar Booth --}}
    <div class="flex justify-center">
        @if($booth->gambar)
            <img src="{{ asset('storage/'.$booth->gambar) }}" width="250" class="rounded-xl mb-4">
        @endif
    </div>

    {{-- Informasi Detail Booth --}}
    <div class="space-y-3">
        <p><strong>Nama Booth:</strong> {{ $booth->nama_booth }}</p>
        <p><strong>Kapasitas:</strong> Max {{ $booth->kapasitas }} orang</p>
        <p><strong>Dibuat:</strong> {{ $booth->created_at ? $booth->created_at->format('d M Y H:i') : '-' }}</p>
        <p><strong>Diedit:</strong> {{ $booth->updated_at ? $booth->updated_at->format('d M Y H:i') : '-' }}</p>
    </div>

    {{-- Tombol Kembali --}}
    <div class="flex justify-between mt-6">
        <a href="{{ route('admin.booth.index') }}"
            class="px-4 py-2 border rounded-xl hover:bg-gray-100">
            Kembali
        </a>
    </div>

</div>
@endsection