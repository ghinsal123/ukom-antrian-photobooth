@extends('Operator.layout')

@section('content')

<div class="container mx-auto px-4">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
        <h2 class="text-3xl md:text-2xl font-bold text-gray-800">Daftar Antrian</h2>

        <div class="flex gap-3">
            <!-- Form Search -->
            <form method="GET" action="{{ route('operator.antrian.index') }}" class="flex">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama / nomor / booth / paket..."
                    class="px-3 py-2 w-70 rounded-lg border border-gray-500 focus:ring-2 focus:ring-pink-400 focus:outline-none"
                />
                <button
                    type="submit"
                    class="ml-2 bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-all">
                    Cari
                </button>
            </form>

            <!-- Tombol Tambah -->
            <a href="{{ route('operator.antrian.create') }}" 
                class="bg-yellow-500 text-white font-semibold px-5 py-2 rounded-xl shadow-lg hover:bg-yellow-600 transition-all">
                + Tambah Antrian
            </a>
        </div>
    </div>

    @php
    function boothColor($name) {
        $colors = ['purple', 'blue', 'green', 'yellow', 'purple', 'pink', 'indigo', 'teal', 'orange'];
        $index = abs(crc32($name)) % count($colors);
        $color = $colors[$index];
        return "bg-{$color}-500 text-white";
    }
    @endphp

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse rounded-3xl shadow-2xl overflow-hidden">
            <thead class="bg-linear-to-r from-pink-300 to-pink-500 text-white">
                <tr>
                    <th class="px-6 py-3">Nomor</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">No. Telp</th>
                    <th class="px-6 py-3">Booth</th>
                    <th class="px-6 py-3">Paket</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Catatan</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($antrian as $item)
                <tr class="bg-white shadow-md hover:shadow-lg">

                    {{-- Nomor Antrian --}}
                    <td class="px-4 py-3 font-bold text-pink-700">
                        {{ $item->nomor_antrian }}
                    </td>

                    {{-- Nama --}}
                    <td class="px-4 py-3 font-medium text-pink-600">
                        {{ $item->pengguna->nama_pengguna ?? '-' }}
                    </td>

                    {{-- No. Telp --}}
                    <td class="px-4 py-3 text-gray-700 font-semibold">
                        {{ $item->pengguna->no_telp ?? '-' }}
                    </td>

                    {{-- Booth --}}
                    <td class="px-4 py-3 font-semibold text-center
                        {{ $item->booth ? boothColor($item->booth->nama_booth) : 'bg-gray-300 text-gray-800' }}">
                        {{ $item->booth->nama_booth ?? '-' }}
                    </td>

                    {{-- Paket --}}
                    <td class="px-4 py-3 text-pink-500 font-semibold">
                        {{ $item->paket->nama_paket }}
                    </td>

                    {{-- Tanggal --}}
                    <td class="px-4 py-3 text-pink-500 font-semibold">
                        {{ $item->tanggal }}
                    </td>

                    {{-- Catatan --}}
                    <td class="px-4 py-3 text-gray-600 italic max-w-[200px] truncate">
                        {{ $item->catatan ?? '-' }}
                    </td>

                    {{-- Status --}}
                    <td class="px-4 py-3 text-center">
                        @if($item->status === 'menunggu')
                            <span class="bg-yellow-100 text-yellow-500 px-2 py-1 rounded-full text-sm font-semibold">
                                Menunggu
                            </span>
                        @elseif($item->status === 'proses')
                            <span class="bg-blue-100 text-blue-500 px-2 py-1 rounded-full text-sm font-semibold">
                                Proses
                            </span>
                        @elseif($item->status === 'selesai')
                            <span class="bg-green-100 text-green-500 px-2 py-1 rounded-full text-sm font-semibold">
                                Selesai
                            </span>
                        @elseif($item->status === 'dibatalkan')
                            <span class="bg-red-100 text-red-500 px-2 py-1 rounded-full text-sm font-semibold">
                                Dibatalkan
                            </span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-4 py-3 text-center flex gap-2 justify-center">
                        <a href="{{ route('operator.antrian.show', $item->id) }}" 
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
