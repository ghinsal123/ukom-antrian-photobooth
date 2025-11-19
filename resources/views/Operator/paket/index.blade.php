@extends('Operator.layout')

@section('content')
<h2 class="text-xl font-bold mb-4">Daftar Paket Booth</h2>

<table class="min-w-full mt-4 bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-3">Nama Paket</th>
            <th class="p-3">Harga</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($paket as $p)
        <tr class="border-b">
            <td class="p-3">{{ $p->nama_paket }}</td>
            <td class="p-3">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
            <td class="p-3">
                <a href="/operator/paket/show/{{ $p->id }}" class="text-blue-600">Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
