@extends('Operator.layout')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

{{-- Notifikasi Error --}}
@if (session('error'))
<div id="popupError" class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
    <div class="popupContent bg-white p-8 rounded-2xl shadow-xl w-[350px] text-center transform scale-100 transition-all duration-300 opacity-100">
        <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-full border border-red-400 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <p class="text-gray-800 text-lg">{{ session('error') }}</p>
        <button onclick="document.getElementById('popupError').remove()"
                class="mt-4 px-4 py-2 bg-red-500 text-white rounded-xl hover:bg-red-600">
            OK
        </button>
    </div>
</div>
@endif

{{-- Notifikasi Info --}}
@if (session('info'))
<div id="popupInfo" class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
    <div class="popupContent bg-white p-8 rounded-2xl shadow-xl w-[350px] text-center transform scale-100 transition-all duration-300 opacity-100">
        <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-full border border-blue-400 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 1010 10A10 10 0 0012 2z" />
            </svg>
        </div>
        <p class="text-gray-800 text-lg">{{ session('info') }}</p>
        <button onclick="document.getElementById('popupInfo').remove()"
                class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">
            OK
        </button>
    </div>
</div>
@endif


    {{-- Header + Pencarian + Tambah --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
        <h2 class="text-3xl md:text-2xl font-bold text-gray-800">Daftar Antrian</h2>
        <div class="flex gap-3">
            <form method="GET" action="{{ route('operator.antrian.index') }}" class="flex">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama / nomor telepon..."
                       class="px-3 py-2 w-70 rounded-lg border border-gray-500 focus:ring-2 focus:ring-pink-400 focus:outline-none"/>
                <button type="submit" class="ml-2 bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-all">Cari</button>
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

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $antrian->links() }}
    </div>
</div>
@endsection
