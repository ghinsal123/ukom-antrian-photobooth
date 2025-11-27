@extends('admin.layouts.app')

@section('title', 'Pengguna')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">
    
    {{-- HEADER + BUTTON TAMBAH --}}
    <div class="flex justify-between items-start sm:items-center mb-5">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Pengguna</h2>

        <a href="{{ route('admin.pengguna.create') }}" 
            class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600 shadow whitespace-nowrap">
            + Tambah Operator
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

                {{-- PESAN --}}
                <p class="text-lg font-semibold text-gray-700 mb-4">
                    {{ session('success') }}
                </p>

                {{-- TOMBOL TUTUP --}}
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

    {{-- FORM PENCARIAN --}}
    <form method="GET" action="{{ route('admin.pengguna.index') }}" 
        class="mb-4 flex gap-2 items-center"
        id="searchForm">

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama / telepon / role..."
            class="w-64 border rounded-xl px-3 py-2"
            oninput="handleSearch(this)">

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl">
            Cari
        </button>
    </form>

    {{-- AUTO SUBMIT JIKA FIELD KOSONG --}}
    <script>
        function handleSearch(input) {
            if (input.value === "") {
                document.getElementById("searchForm").submit();
            }
        }
    </script>

    {{-- TABEL DATA PENGGUNA --}}
    <div class="overflow-x-auto">
        <table class="min-w-[600px] w-full border-collapse text-xs sm:text-sm md:text-base">

            <thead>
                <tr class="bg-pink-100 text-left">
                    <th class="p-3">#</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Nomor Telepon</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pengguna as $index => $user)
                <tr class="border-b hover:bg-pink-50">

                    {{-- NOMOR BERDASARKAN PAGINATION --}}
                    <td class="p-3">
                        {{ ($pengguna->currentPage() - 1) * $pengguna->perPage() + ($index + 1) }}
                    </td>

                    {{-- NAMA & TELEPON --}}
                    <td class="p-3">{{ $user->nama_pengguna }}</td>
                    <td class="p-3">{{ $user->no_telp }}</td>

                    {{-- ROLE BADGE --}}
                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-xs sm:text-sm 
                            {{ $user->role == 'admin' ? 'bg-purple-200 text-purple-600' : 
                            ($user->role == 'operator' ? 'bg-blue-200 text-blue-600' : 
                            'bg-gray-200 text-gray-600') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="p-3 flex flex-wrap gap-2">

                        {{-- DETAIL --}}
                        <a href="{{ route('admin.pengguna.show', $user->id) }}"
                            class="px-3 py-1 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                            Detail
                        </a>

                        {{-- EDIT (disabled untuk customer) --}}
                        @if($user->role === 'customer')
                            <button class="px-3 py-1 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed" disabled>
                                Edit
                            </button>
                        @else
                            <a href="{{ route('admin.pengguna.edit', $user->id) }}"
                                class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                Edit
                            </a>
                        @endif

                        {{-- HAPUS (hanya operator yang bisa dihapus) --}}
                        @if($user->role === 'admin' || $user->role === 'customer')
                            <button class="px-3 py-1 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed" disabled>
                                Hapus
                            </button>
                        @else
                            <form action="{{ route('admin.pengguna.destroy', $user->id) }}" 
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus operator?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        @endif

                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">
                        Pengguna tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-5">
        {{ $pengguna->links() }}
    </div>
</div>
@endsection
