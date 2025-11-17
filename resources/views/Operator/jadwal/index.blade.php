@extends('Operator.layout')

@section('content')
<div class="container mx-auto px-4">

    <h2 class="text-3xl font-bold mb-6 text-gray-800">Daftar Jadwal Antrian</h2>

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse rounded-3xl shadow-2xl overflow-hidden">
            <thead class="bg-linear-to-r from-pink-300 to-pink-500 text-white">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Nomor Antrian</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwals as $j)
                <tr class="bg-white hover:bg-pink-50 transition-all transform hover:scale-105 shadow-md hover:shadow-lg">
                    <td class="px-4 py-3 text-center font-semibold text-pink-600">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 text-pink-500 font-semibold">{{ $j->tanggal }}</td>
                    <td class="px-4 py-3 text-pink-500 font-semibold">{{ $j->nomor_antrian }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($j->status === 'selesai')
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-sm font-semibold">Selesai</span>
                        @elseif($j->status === 'dalam proses')
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full text-sm font-semibold">Proses</span>
                        @else
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-sm font-semibold">Batal</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('jadwal.show', $j->id) }}" 
                           class="bg-pink-500 text-white px-4 py-2 rounded-xl hover:bg-pink-600 shadow-lg transition-all transform hover:scale-105">
                           Lihat Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection