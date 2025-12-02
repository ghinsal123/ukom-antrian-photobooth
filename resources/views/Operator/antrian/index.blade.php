@extends('Operator.layout')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

    {{-- POPUP MESSAGES --}}
    @php
    $colors = [
        'success' => ['border' => 'border-green-400', 'text' => 'text-green-500', 'bg' => 'bg-green-500', 'hover' => 'hover:bg-green-600'],
        'error'   => ['border' => 'border-red-400',   'text' => 'text-red-500',   'bg' => 'bg-red-500',   'hover' => 'hover:bg-red-600'],
        'info'    => ['border' => 'border-blue-400',  'text' => 'text-blue-500',  'bg' => 'bg-blue-500',  'hover' => 'hover:bg-blue-600'],
    ];
    @endphp

    @foreach (['success', 'error', 'info'] as $msg)
        @if(session($msg))
        <div id="popup{{ ucfirst($msg) }}" class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
            <div class="popupContent bg-white p-8 rounded-2xl shadow-xl w-[350px] text-center scale-75 opacity-0 animate-zoomIn">
                
                <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-full border mb-4 {{ $colors[$msg]['border'] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 {{ $colors[$msg]['text'] }}" 
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        @if($msg=='success')
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        @elseif($msg=='error')
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z" />
                        @endif
                    </svg>
                </div>

                <p class="text-lg font-semibold text-gray-700 mb-4">
                    {{ session($msg) }}
                </p>

                <button onclick="document.getElementById('popup{{ ucfirst($msg) }}').remove()"
                        class="px-5 py-2 {{ $colors[$msg]['bg'] }} {{ $colors[$msg]['hover'] }} text-white rounded-xl shadow">
                    OK
                </button>

            </div>
        </div>
        @endif
    @endforeach
    <style>
    @keyframes zoomIn {
        0% { transform: scale(0.6); opacity: 0; }
        70% { transform: scale(1.05); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }
    .animate-zoomIn {
        animation: zoomIn 0.25s ease-out forwards;
    }
    </style>

    {{-- Header + Pencarian + Tambah --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
        <h2 class="text-3xl md:text-2xl font-bold text-gray-800">Daftar Antrian</h2>
        <div class="flex gap-3 items-center">
            <form method="GET" action="{{ route('operator.antrian.index') }}" class="flex gap-2 items-center">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama / nomor telepon..."
                    class="px-3 py-2 w-70 rounded-lg border border-gray-500 focus:ring-2 focus:ring-pink-400 focus:outline-none"/>

                <select name="sort" class="px-3 py-2 rounded-lg border border-gray-500 focus:ring-2 focus:ring-pink-400 focus:outline-none">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>

                <button type="submit" class="ml-2 bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-all">
                    Filter
                </button>
            </form>

            <a href="{{ route('operator.antrian.create') }}" 
               class="bg-yellow-500 text-white font-semibold px-5 py-2 rounded-xl shadow-lg hover:bg-yellow-600 transition-all">
                + Tambah Antrian
            </a>
        </div>
    </div>

    {{-- Tabel Antrian --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
        <thead>
            <tr class="bg-pink-100 text-center">
                <th class="p-3">No</th>
                <th class="p-3">Antrian</th>
                <th class="p-3">Customer</th>
                <th class="p-3">Telepon</th>
                <th class="p-3">Tanggal</th>
                <th class="p-3">Jam</th>
                <th class="p-3">Status</th>
                <th class="p-3">Catatan</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($antrian as $a)
            <tr class="text-center border-b hover:bg-pink-50">
                <td class="p-3">{{ $loop->iteration }}</td>
                <td class="p-3">{{ $a->nomor_antrian }}</td>
                <td class="p-3">{{ $a->pengguna->nama_pengguna }}</td>
                <td class="p-3">+62 {{ $a->pengguna->no_telp ?? '-' }}</td>
                <td class="p-3">{{ \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') }}</td>
                <td class="p-3">{{ $a->jam }}</td>
                <td class="p-3">{{ ucfirst($a->status) }}</td>
                <td class="p-3">{{ $a->catatan ?? '-' }}</td>
                <td class="p-3 flex gap-2 justify-center">
                    <a href="{{ route('operator.antrian.show', $a->id) }}" class="px-3 py-1 bg-purple-500 text-white rounded-lg hover:bg-purple-600">Detail</a>
                    <form action="{{ route('operator.antrian.delete', $a->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus antrian?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center py-6 text-gray-500">Antrian tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
        </table>
    </div>

    {{--  Pagination --}}
    @if ($antrian->hasPages())
    <div class="mt-4 flex justify-center space-x-1">
        {{-- Previous Page Link --}}
        @if ($antrian->onFirstPage())
            <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed">&laquo;</span>
        @else
            <a href="{{ $antrian->previousPageUrl() }}" class="px-3 py-1 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">&laquo;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($antrian->links()->elements[0] as $page => $url)
            @if ($page == $antrian->currentPage())
                <span class="px-3 py-1 bg-pink-300 text-white rounded-lg">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="px-3 py-1 bg-pink-100 text-pink-700 rounded-lg hover:bg-pink-200 transition">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($antrian->hasMorePages())
            <a href="{{ $antrian->nextPageUrl() }}" class="px-3 py-1 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition">&raquo;</a>
        @else
            <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded-lg cursor-not-allowed">&raquo;</span>
        @endif
    </div>
    @endif
</div>
@endsection
