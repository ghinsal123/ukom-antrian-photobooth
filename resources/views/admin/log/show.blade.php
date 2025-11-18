@extends('admin.layouts.app')

@section('title', 'Detail Log')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow w-full max-w-2xl mx-auto">

    <h2 class="text-xl font-bold mb-4">Detail Log</h2>

    <ul class="space-y-2">
        <li><strong>ID:</strong> {{ $log->id }}</li>
        <li><strong>Pengguna:</strong> {{ $log->pengguna->nama ?? '-' }}</li>
        <li><strong>Antrian:</strong> {{ $log->antrian->id ?? '-' }}</li>
        <li><strong>Aksi:</strong> {{ $log->aksi }}</li>
        <li><strong>Keterangan:</strong> {{ $log->keterangan ?? '-' }}</li>
        <li><strong>Dibuat:</strong> {{ $log->created_at }}</li>
    </ul>

    <div class="mt-5 flex gap-3">
        <a href="{{ route('admin.log.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>

        <form action="{{ route('admin.log.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Hapus log ini?')">
            @csrf
            @method('DELETE')
            <button class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
        </form>
    </div>

</div>
@endsection
