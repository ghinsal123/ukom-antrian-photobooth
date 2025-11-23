@extends('Operator.layout')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

    {{-- header: judul dan form pencarian --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
        <h2 class="text-3xl font-bold text-gray-800 mb-2 md:mb-0">Daftar Booth</h2>

        {{-- form pencarian booth --}}
        <form method="GET" action="{{ route('operator.booth.index') }}" class="flex gap-2 items-center w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama booth..."
                   class="w-full md:w-64 border border-gray-500 rounded-xl px-3 py-2">
            <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600">
                Cari
            </button>
        </form>
    </div>

    {{-- tabel booth --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-pink-100 text-center">
                    <th class="px-6 py-3 align-middle">Gambar</th>
                    <th class="px-6 py-3 align-middle">Nama Booth</th>
                    <th class="px-6 py-3 align-middle">Kapasitas</th>
                    <th class="px-6 py-3 align-middle">Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- tampilkan setiap booth --}}
                @forelse ($booths as $booth)
                <tr class="border-b hover:bg-pink-50">
                    <td class="px-4 py-3">
                        <div class="flex justify-center items-center">
                            {{-- tampilkan gambar jika ada --}}
                            @if($booth->gambar)
                                <img src="{{ asset('storage/' . $booth->gambar) }}" 
                                     alt="{{ $booth->nama_booth }}" 
                                     class="w-20 h-20 object-cover rounded-lg shadow-md">
                            @else
                                <span class="text-gray-400 italic">Tidak ada gambar</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3 font-semibold text-pink-600 text-center">{{ $booth->nama_booth }}</td>
                    <td class="px-4 py-3 font-bold text-pink-500 text-center">{{ $booth->kapasitas }}</td>
                    <td class="px-4 py-3 text-center">
                        {{-- tombol detail booth --}}
                        <a href="{{ route('operator.booth.show', $booth->id) }}" 
                           class="bg-pink-500 text-white px-4 py-2 rounded-xl hover:bg-pink-600 shadow-lg transition-all transform hover:scale-105">
                           Detail
                        </a>
                    </td>
                </tr>
                {{-- jika tidak ada booth --}}
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">Booth tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
