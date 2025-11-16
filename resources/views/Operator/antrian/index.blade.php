@extends('Operator.layout')

@section('content')
<h2 class="text-xl font-bold mb-4">Daftar Antrian</h2>

<a href="{{ route('operator.antrian.create') }}" class="bg-pink-500 text-white px-4 py-2 rounded">Tambah Antrian</a>

<table class="min-w-full mt-4 bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-3">Nama</th>
            <th class="p-3">Booth</th>
            <th class="p-3">Paket</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Status</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($antrian as $item)
        <tr class="border-b">
            <td class="p-3">{{ $item->pengguna->nama ?? '-' }}</td>
            <td class="p-3">{{ $item->booth->nama_booth }}</td>
            <td class="p-3">{{ $item->paket->nama_paket }}</td>
            <td class="p-3">{{ $item->tanggal }}</td>
            <td class="p-3 capitalize">{{ $item->status }}</td>
            <td class="p-3 flex gap-2">

                <a href="{{ route('operatorantrian.show', $item->id) }}" class="text-blue-600">Detail</a>
                <a href="{{ route('operator.antrian.edit', $item->id) }}" class="text-yellow-600">Edit</a>

                <form action="{{ route('operator.antrian.delete', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
