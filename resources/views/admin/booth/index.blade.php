@extends('admin.layouts.app')

@section('title', 'Booth')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

    <div class="flex justify-between items-center mb-5">
        <h2 class="text-2xl font-semibold text-gray-700">Data Booth</h2>

        <a href="{{ route('admin.booth.create') }}" 
           class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600 shadow">
            + Tambah Booth
        </a>
    </div>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-pink-100 text-left">
                <th class="p-3">#</th>
                <th class="p-3">Nama Booth</th>
                <th class="p-3">Kapasitas</th>
                <th class="p-3">Status</th>
                <th class="p-3">Jam Mulai</th>
                <th class="p-3">Jam Selesai</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($booths as $index => $booth)
            <tr class="border-b hover:bg-pink-50">
                <td class="p-3">{{ $index + 1 }}</td>
                <td class="p-3">{{ $booth->nama_booth }}</td>
                <td class="p-3">{{ $booth->kapasitas }}</td>
                <td class="p-3">
                    <span class="px-2 py-1 rounded-lg text-white
                        {{ $booth->status == 'kosong' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ ucfirst($booth->status) }}
                    </span>
                </td>
                <td class="p-3">{{ $booth->jam_mulai ?? '-' }}</td>
                <td class="p-3">{{ $booth->jam_selesai ?? '-' }}</td>

                <td class="p-3 flex gap-2">
                    <a href="{{ route('admin.booth.edit', $booth->id) }}" 
                       class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Edit
                    </a>

                    <form action="{{ route('admin.booth.destroy', $booth->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus booth?')">
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
