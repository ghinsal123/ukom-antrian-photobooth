@extends('Operator.layout')

@section('content')
<div class="container">

    <h2 class="text-2xl font-bold mb-4">Daftar Jadwal Antrian</h2>

    <table class="table-auto w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-3 py-2 border">#</th>
                <th class="px-3 py-2 border">Tanggal</th>
                <th class="px-3 py-2 border">Nomor Antrian</th>
                <th class="px-3 py-2 border">Status</th>
                <th class="px-3 py-2 border">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($jadwals as $j)
            <tr>
                <td class="px-3 py-2 border">{{ $loop->iteration }}</td>
                <td class="px-3 py-2 border">{{ $j->tanggal }}</td>
                <td class="px-3 py-2 border">{{ $j->nomor_antrian }}</td>
                <td class="px-3 py-2 border">{{ ucfirst($j->status) }}</td>
                <td class="px-3 py-2 border">
                    <a href="{{ route('jadwal.show', $j->id) }}" class="text-blue-600 font-semibold">
                        Lihat Detail
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>
@endsection
