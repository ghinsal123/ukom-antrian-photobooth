@extends('admin.layouts.app')

@section('title', 'Paket')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

    <div class="flex justify-between items-center mb-5">
        <h2 class="text-2xl font-semibold text-gray-700">Data Paket</h2>

        <a href="{{ route('admin.paket.create') }}" 
           class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600 shadow">
            + Tambah Paket
        </a>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-pink-100 text-left">
                <th class="p-3">#</th>
                <th class="p-3">Nama Paket</th>
                <th class="p-3">Harga</th>
                <th class="p-3">Deskripsi</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($pakets as $index => $paket)
            <tr class="border-b hover:bg-pink-50">
                <td class="p-3">{{ $index + 1 }}</td>
                <td class="p-3">{{ $paket->nama_paket }}</td>
                <td class="p-3">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                <td class="p-3">{{ Str::limit($paket->deskripsi, 40) }}</td>

                <td class="p-3 flex gap-2">
                    <a href="{{ route('admin.paket.show', $paket->id) }}" 
                       class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600">
                        Detail
                    </a>

                    <a href="{{ route('admin.paket.edit', $paket->id) }}" 
                       class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Edit
                    </a>

                    <form action="{{ route('admin.paket.destroy', $paket->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus paket?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>
@endsection
