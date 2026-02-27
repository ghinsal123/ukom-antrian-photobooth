@extends('admin.layouts.app')

@section('title', 'Booth')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

    <div class="flex justify-between items-center mb-5">
        <h2 class="text-2xl font-semibold text-gray-700">Data Booth</h2>

        <a href="{{ route('admin.booth.create') }}" 
           class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600 shadow">
            + Tambah Booth
        </a>
    </div>

    {{-- POPUP SUCCESS --}}
    @if (session('success'))
    <div id="popupSuccess" class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">

        <div class="popupContent bg-white p-8 rounded-2xl shadow-xl w-[350px] text-center scale-75 opacity-0 animate-zoomIn">
            
            <div class="mx-auto w-20 h-20 flex items-center justify-center 
                        rounded-full border border-green-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="w-10 h-10 text-green-500" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <p class="text-lg font-semibold text-gray-700 mb-4">
                {{ session('success') }}
            </p>

            <button onclick="document.getElementById('popupSuccess').remove()"
                class="px-5 py-2 bg-pink-500 text-white rounded-lg shadow hover:bg-pink-600">
                OK
            </button>

        </div>
    </div>

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

    {{-- SEARCH --}}
    <form method="GET" action="{{ route('admin.booth.index') }}" class="mb-4 flex gap-2 items-center" id="searchForm">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Cari nama booth..." 
               class="w-64 border rounded-xl px-3 py-2" 
               oninput="handleSearch(this)">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl">Cari</button>
    </form>

    <script>
        function handleSearch(input) {
            if (input.value === "") {
                document.getElementById("searchForm").submit();
            }
        }
    </script>

    <div class="overflow-x-auto">
        <table class="min-w-[600px] w-full border-collapse text-xs sm:text-sm md:text-base">
            <thead>
                <tr class="bg-pink-100 text-left">
                    <th class="p-3">#</th>
                    <th class="p-3">Nama Booth</th>
                    <th class="p-3">Kapasitas</th>
                    <th class="p-3">Gambar</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($booths as $index => $b)

                @php
                    $gambar = is_array($b->gambar) ? $b->gambar : json_decode($b->gambar, true);
                @endphp

                <tr class="border-b hover:bg-pink-50">
                    <td class="p-3">{{ $index + 1 + ($booths->currentPage()-1) * $booths->perPage() }}</td>

                    <td class="p-3">{{ $b->nama_booth }}</td>

                    <td class="p-3">max {{ $b->kapasitas }} orang</td>

                    <td class="p-3">
                        @if($gambar && count($gambar) > 0)
                            <img src="{{ asset('storage/' . $gambar[0]) }}" 
                                 class="w-16 h-16 object-cover rounded-lg">
                        @else
                            <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </td>

                    <td class="p-3 flex gap-2">
                        <a href="{{ route('admin.booth.show', $b->id) }}" 
                           class="px-3 py-1 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                           Detail
                        </a>

                        <a href="{{ route('admin.booth.edit', $b->id) }}" 
                           class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                           Edit
                        </a>

                        <form action="{{ route('admin.booth.destroy', $b->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus booth?')">
                            @csrf 
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Booth tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $booths->links() }}
    </div>

</div>
@endsection
