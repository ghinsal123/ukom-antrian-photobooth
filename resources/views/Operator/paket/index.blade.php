@extends('Operator.layout')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-center mb-4">
    <!-- JUDUL -->
    <h2 class="text-3xl font-bold text-gray-800 mb-2 md:mb-0">Daftar Paket</h2>

    <!-- FORM PENCARIAN -->
    <form method="GET" action="{{ route('operator.paket.index') }}" class="flex gap-2 items-center w-full md:w-auto">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama paket..."
               class="w-full md:w-64 border border-gray-500 rounded-xl px-3 py-2">
        <button type="submit" class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600">
            Cari
        </button>
    </form>
</div>

<div class="overflow-x-auto">
    <table class="table-auto w-full border-collapse rounded-3xl shadow-2xl overflow-hidden">
        <thead class="bg-linear-to-r from-pink-300 to-pink-500 text-white">
            <tr>
                <th class="px-6 py-3">Gambar</th>
                <th class="px-6 py-3">Nama Paket</th>
                <th class="px-6 py-3">Deskripsi</th>
                <th class="px-6 py-3">Harga</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pakets as $paket)
            <tr class="bg-white shadow-md hover:shadow-lg">
                <td class="px-4 py-3">
                    <div class="flex justify-center items-center">
                        @if($paket->gambar)
                            <img src="{{ asset('storage/' . $paket->gambar) }}" 
                                 alt="{{ $paket->nama_paket }}" 
                                 class="w-20 h-20 object-cover rounded-lg shadow-md">
                        @else
                            <span class="text-gray-400 italic">Tidak ada gambar</span>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-3 font-semibold text-pink-600 text-center">{{ $paket->nama_paket }}</td>
                
                <!-- DESKRIPSI SINGKAT -->
                <td class="px-4 py-3 text-gray-700 text-center">
                    {{ \Illuminate\Support\Str::limit($paket->deskripsi, 30, '...') ?? '-' }}
                </td>
                
                <td class="px-4 py-3 font-bold text-pink-500 text-center">Rp {{ number_format($paket->harga, 0, ',', '.') }}</td>
                
                <td class="px-4 py-3 text-center">
                    <a href="{{ route('operator.paket.show', $paket->id) }}" 
                       class="bg-pink-500 text-white px-4 py-2 rounded-xl hover:bg-pink-600 shadow-lg transition-all transform hover:scale-105">
                       Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-6 text-gray-500">Paket tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
