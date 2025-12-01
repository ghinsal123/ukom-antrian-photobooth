@extends('Operator.layout')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
        <h2 class="text-3xl font-bold text-gray-800 mb-2 md:mb-0">Daftar Paket</h2>

        {{-- form pencarian paket --}}
        <form 
            method="GET" 
            action="{{ route('operator.paket.index') }}" 
            class="flex gap-2 items-center w-full md:w-auto"
        >
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="cari nama paket..."
                class="w-full md:w-64 border border-gray-500 rounded-xl px-3 py-2"
            >

            <button 
                type="submit" 
                class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600"
            >
                Cari
            </button>
        </form>
    </div>

    {{-- tabel daftar paket --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-pink-100 text-center">
                    <th class="px-6 py-3">gambar</th>
                    <th class="px-6 py-3">nama paket</th>
                    <th class="px-6 py-3">deskripsi</th>
                    <th class="px-6 py-3">harga</th>
                    <th class="px-6 py-3">aksi</th>
                </tr>
            </thead>

            {{-- isi tabel --}}
            <tbody>
                @forelse ($pakets as $paket)
                <tr class="border-b hover:bg-pink-50">

                    {{-- gambar paket --}}
                    <td class="px-4 py-3">
                        <div class="flex justify-center items-center">
                            @if($paket->gambar)
                                <img 
                                    src="{{ asset('storage/' . $paket->gambar) }}" 
                                    alt="{{ $paket->nama_paket }}" 
                                    class="w-20 h-20 object-cover rounded-lg shadow-md"
                                >
                            @else
                                <span class="text-gray-400 italic">tidak ada gambar</span>
                            @endif
                        </div>
                    </td>

                    {{-- nama paket --}}
                    <td class="px-4 py-3 font-semibold text-pink-600 text-center">
                        {{ $paket->nama_paket }}
                    </td>

                    {{-- deskripsi --}}
                    <td class="px-4 py-3 text-gray-700 text-center">
                        {{ \Illuminate\Support\Str::limit($paket->deskripsi, 30, '...') ?? '-' }}
                    </td>

                    {{-- harga paket --}}
                    <td class="px-4 py-3 font-bold text-pink-500 text-center">
                        Rp {{ number_format($paket->harga, 0, ',', '.') }}
                    </td>

                    {{-- tombol aksi --}}
                    <td class="px-4 py-3 text-center">
                        <a 
                            href="{{ route('operator.paket.show', $paket->id) }}" 
                            class="bg-purple-500 text-white px-4 py-2 rounded-xl hover:bg-purple-600 shadow-lg transition-all transform hover:scale-105"
                        >
                            Detail
                        </a>
                    </td>

                </tr>
                @empty
                
                {{-- jika data kosong --}}
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">
                        paket tidak ditemukan
                    </td>
                </tr>

                @endforelse
            </tbody>

        </table>
    </div>

</div>
@endsection
