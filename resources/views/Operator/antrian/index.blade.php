@extends('Operator.layout')

@section('content')
<div class="container mx-auto px-4">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Daftar Antrian</h2>
        <a href="{{ route('operator.antrian.create') }}" 
           class="bg-yellow-500 text-white font-semibold px-5 py-2 rounded-xl shadow-lg hover:bg-yellow-600 transition-all">
           + Tambah Antrian
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse rounded-3xl shadow-2xl overflow-hidden">
            <thead class="bg-linear-to-r from-pink-300 to-pink-500 text-white">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Booth</th>
                    <th class="px-6 py-3">Paket</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($antrian as $item)
                <tr class="bg-white hover:bg-pink-50 transition-all transform hover:scale-105 shadow-md hover:shadow-lg">
                    <td class="px-4 py-3 font-medium text-pink-600">{{ $item->pengguna->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-pink-500 font-semibold">{{ $item->booth->nama_booth }}</td>
                    <td class="px-4 py-3 text-pink-500 font-semibold">{{ $item->paket->nama_paket }}</td>
                    <td class="px-4 py-3 text-pink-500 font-semibold">{{ $item->tanggal }}</td>
                    <td class="px-4 py-3 text-center">
                        @if($item->status === 'selesai')
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-sm font-semibold">Selesai</span>
                        @elseif($item->status === 'dalam proses')
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full text-sm font-semibold">Proses</span>
                        @else
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-sm font-semibold">Batal</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center flex gap-2 justify-center">
                        <a href="{{ route('operatorantrian.show', $item->id) }}" 
                           class="bg-blue-500 text-white px-3 py-1 rounded-xl hover:bg-blue-600 shadow-md transition-all">
                           Detail
                        </a>
                        <a href="{{ route('operator.antrian.edit', $item->id) }}" 
                           class="bg-yellow-400 text-white px-3 py-1 rounded-xl hover:bg-yellow-500 shadow-md transition-all">
                           Edit
                        </a>
                        <form action="{{ route('operator.antrian.delete', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="bg-red-500 text-white px-3 py-1 rounded-xl hover:bg-red-600 shadow-md transition-all">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection