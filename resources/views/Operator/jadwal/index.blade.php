@extends('Operator.layout')

@section('content')
<h2 class="text-xl font-bold mb-4">Status Jadwal & Ruangan</h2>

<table class="min-w-full mt-4 bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-200">
            <th class="p-3">Booth</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Status</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($jadwal as $j)
        <tr class="border-b">
            <td class="p-3">{{ $j->booth }}</td>
            <td class="p-3">{{ $j->tanggal }}</td>
            <td class="p-3">{{ ucfirst($j->status) }}</td>
            <td class="p-3">
                <a href="/operator/jadwal/show/{{ $j->id }}" class="text-blue-600">Detail</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
