@extends('admin.layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-xl mx-auto">

    <h2 class="text-2xl font-semibold text-gray-700 mb-5">Detail Pengguna</h2>

    @if($pengguna->foto)
        <img src="{{ asset('storage/'.$pengguna->foto) }}" width="150" class="rounded-xl mb-4">
    @endif

    <div class="space-y-3">
        <p><strong>Nama:</strong> {{ $pengguna->nama_pengguna }}</p>
        <p><strong>Telepon:</strong> {{ $pengguna->no_telp }}</p>
        <p><strong>Role:</strong> {{ ucfirst($pengguna->role) }}</p>
        <p><strong>Dibuat:</strong> {{ $pengguna->created_at->format('d M Y H:i') }}</p>
    </div>

    <div class="flex justify-between mt-6">
        <a href="{{ route('admin.pengguna.index') }}"
            class="px-4 py-2 border rounded-xl hover:bg-gray-100">
            Kembali
        </a>
    </div>

</div>
@endsection
