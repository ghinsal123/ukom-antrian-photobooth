@extends('Operator.layout')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

    {{-- notifikasi sukses --}}
    @if (session('success'))
    <div id="popupSuccess" class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
        <div class="popupContent bg-white p-8 rounded-2xl shadow-xl w-[350px] text-center transform scale-100 transition-all duration-300 opacity-100">
        
            <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-full border border-green-400 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <p class="text-gray-800 text-lg">{{ session('success') }}</p>

            <button onclick="document.getElementById('popupSuccess').remove()"
                    class="mt-4 px-4 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600">
                OK
            </button>
        </div>
    </div>
    @endif

    {{-- header halaman --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
        <h2 class="text-3xl md:text-2xl font-bold text-gray-800">Daftar Antrian</h2>

        <div class="flex gap-3">
            {{-- form pencarian --}}
            <form method="GET" action="{{ route('operator.antrian.index') }}" class="flex">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama / nomor telepon / booth / paket..."
                    class="px-3 py-2 w-70 rounded-lg border border-gray-500 focus:ring-2 focus:ring-pink-400 focus:outline-none"
                />
                <button
                    type="submit"
                    class="ml-2 bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-all">
                    Cari
                </button>
            </form>

            {{-- tombol tambah antrian --}}
            <a href="{{ route('operator.antrian.create') }}" 
                class="bg-yellow-500 text-white font-semibold px-5 py-2 rounded-xl shadow-lg hover:bg-yellow-600 transition-all">
                + Tambah Antrian
            </a>
        </div>
    </div>

    {{-- tabel daftar antrian --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-pink-100 text-center">
                    <th class="p-3">Nomor Antrian</th>
                    <th class="p-3">Pengguna</th>
                    <th class="p-3">Nomor Telepon</th> 
                    <th class="p-3">Booth</th>
                    <th class="p-3">Paket</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Catatan</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                {{-- tampilkan setiap antrian --}}
                @forelse($antrian as $index => $a)
                <tr class="text-center border-b hover:bg-pink-50">
                    <td class="p-3">{{ $a->nomor_antrian }}</td>
                    <td class="p-3">{{ $a->pengguna->nama_pengguna }}</td>
                    <td class="p-3">{{ $a->pengguna->no_telp ?? '-' }}</td>
                    <td class="p-3">{{ $a->booth->nama_booth }}</td>
                    <td class="p-3">{{ $a->paket->nama_paket }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') }}</td>
                    <td class="p-3">{{ ucfirst($a->status) }}</td>
                    <td class="p-3">{{ $a->catatan ?? '-' }}</td>
                    <td class="p-3 flex gap-2 justify-center">
                        {{-- tombol aksi --}}
                        <a href="{{ route('operator.antrian.show', $a->id) }}"
                           class="px-3 py-1 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                            Detail
                        </a>
                        <a href="{{ route('operator.antrian.edit', $a->id) }}"
                           class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Edit
                        </a>
                        <form action="{{ route('operator.antrian.delete', $a->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus antrian?')">
                            @csrf
                            @method('DELETE')

                            <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                {{-- jika tidak ada antrian --}}
                <tr>
                    <td colspan="9" class="text-center py-6 text-gray-500">Antrian tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- pagination --}}
    <div class="mt-4">
        {{ $antrian->links() }}
    </div>

</div>

@endsection
