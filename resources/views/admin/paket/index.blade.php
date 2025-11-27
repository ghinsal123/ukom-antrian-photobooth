@extends('admin.layouts.app')

@section('title', 'Paket')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

    {{-- HEADER HALAMAN + TOMBOL TAMBAH PAKET --}}
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-2xl font-semibold text-gray-700">Data Paket</h2>

        <a href="{{ route('admin.paket.create') }}" 
           class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600 shadow">
            + Tambah Paket
        </a>
    </div>

    {{-- POPUP SUCCESS --}}
    @if (session('success'))
    <div id="popupSuccess" class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">

        <div class="popupContent bg-white p-8 rounded-2xl shadow-xl w-[350px] text-center scale-75 opacity-0 animate-zoomIn">
            
            {{-- ICON SUCCESS --}}
            <div class="mx-auto w-20 h-20 flex items-center justify-center 
                        rounded-full border border-green-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="w-10 h-10 text-green-500" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>

            {{-- TEKS PESAN --}}
            <p class="text-lg font-semibold text-gray-700 mb-4">
                {{ session('success') }}
            </p>

            {{-- TOMBOL TUTUP POPUP --}}
            <button onclick="document.getElementById('popupSuccess').remove()"
                class="px-5 py-2 bg-pink-500 text-white rounded-lg shadow hover:bg-pink-600">
                OK
            </button>

        </div>
    </div>

    {{-- ANIMASI POPUP --}}
    <style>
        @keyframes zoomIn {
            0% { transform: scale(0.6); opacity: 0; }
            70% { transform: scale(1.05); opacity: 1; }
            100% { transform: scale(1.3); opacity: 1; }
        }
        .animate-zoomIn {
            animation: zoomIn 0.25s ease-out forwards;
        }
    </style>
    @endif

    {{-- FORM PENCARIAN PAKET --}}
    <form method="GET" action="{{ route('admin.paket.index') }}" class="mb-4 flex gap-2 items-center" id="searchForm">
        
        {{-- INPUT SEARCH --}}
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama paket..."
            class="w-64 border rounded-xl px-3 py-2"
            oninput="handleSearch(this)">
        
        {{-- TOMBOL CARI --}}
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl">
            Cari
        </button>
    </form>

    {{-- AUTO-SUBMIT KETIKA INPUT SEARCH DIKOSONGKAN --}}
    <script>
        function handleSearch(input) {
            if (input.value === "") {
                document.getElementById("searchForm").submit();
            }
        }
    </script>

    {{-- TABEL DATA PAKET --}}
    <div class="overflow-x-auto">
        <table class="min-w-[650px] w-full border-collapse text-xs sm:text-sm md:text-base">
            <thead>
                <tr class="bg-pink-100 text-left">
                    <th class="p-3">#</th>
                    <th class="p-3">Nama Paket</th>
                    <th class="p-3">Harga</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>

                {{-- LOOPING DATA PAKET --}}
                @forelse($paket as $index => $paket)
                <tr class="border-b hover:bg-pink-50">

                    {{-- NOMOR URUT --}}
                    <td class="p-3">{{ $index + 1 }}</td>

                    {{-- NAMA PAKET --}}
                    <td class="p-3">{{ $paket->nama_paket }}</td>

                    {{-- HARGA PAKET --}}
                    <td class="p-3">
                        Rp {{ number_format($paket->harga, 0, ',', '.') }}
                    </td>

                    {{-- DESKRIPSI (DIPERSINGKAT) --}}
                    <td class="p-3">
                        {{ Str::limit($paket->deskripsi, 50) }}
                    </td>

                    {{-- TOMBOL AKSI --}}
                    <td class="p-3 flex flex-wrap gap-2">

                        {{-- TOMBOL DETAIL --}}
                        <a href="{{ route('admin.paket.show', $paket->id) }}"
                            class="px-3 py-1 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                            Detail
                        </a>

                        {{-- TOMBOL EDIT --}}
                        <a href="{{ route('admin.paket.edit', $paket->id) }}"
                            class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Edit
                        </a>

                        {{-- TOMBOL HAPUS --}}
                        <form action="{{ route('admin.paket.destroy', $paket->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus paket?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>

                {{-- JIKA DATA KOSONG --}}
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">
                        Paket tidak ditemukan.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>
@endsection
