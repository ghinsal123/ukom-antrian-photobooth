@extends('admin.layouts.app')

@section('title', 'Pengguna')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">
    
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-2xl font-semibold text-gray-700">Daftar Pengguna</h2>

        <a href="{{ route('admin.pengguna.create') }}" 
           class="px-4 py-2 bg-pink-500 text-white rounded-xl hover:bg-pink-600 shadow">
            + Tambah Pengguna
        </a>
    </div>
    <form method="GET" action="{{ route('admin.pengguna.index') }}" class="mb-4 flex gap-2 items-center" id="searchForm">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama / telepon / role..."
            class="w-64 border rounded-xl px-3 py-2"
            oninput="handleSearch(this)">

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-xl">
            Cari
        </button>
    </form>

    <script>
        function handleSearch(input) {
            if (input.value === "") {
                document.getElementById("searchForm").submit();
            }
        }
    </script>

    <table class="w-full border-collapse">
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
            @foreach($pengguna as $index => $user)
            <tr class="border-b hover:bg-pink-50">
                <td class="p-3">{{ $index + 1 }}</td>
                <td class="p-3">{{ $user->nama_pengguna }}</td>
                <td class="p-3">{{ $user->no_telp }}</td>
                <td class="p-3">
                    <span class="px-3 py-1 rounded-full text-sm 
                        {{ $user->role == 'admin' ? 'bg-purple-200 text-purple-600' : 
                           ($user->role == 'operator' ? 'bg-blue-200 text-blue-600' : 'bg-gray-200 text-gray-600') }}"
                    >
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('admin.pengguna.show', $user->id) }}" 
                        class="px-3 py-1 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                        Detail
                    </a>

                    <a href="{{ route('admin.pengguna.edit', $user->id) }}" 
                        class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Edit
                    </a>

                    <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus pengguna?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
