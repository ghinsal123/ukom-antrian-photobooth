{{-- FORM PENCARIAN --}}
<form method="GET" class="mb-4 flex gap-2 items-center" id="searchForm">
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

{{-- TABEL --}}
<div class="overflow-x-auto">
    <table class="min-w-[600px] w-full border-collapse text-sm">

        <thead>
            <tr class="bg-pink-100 text-left">
                <th class="p-3">#</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Telepon</th>
                <th class="p-3">Role</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($pengguna as $index => $user)
            <tr class="border-b hover:bg-pink-50">

                <td class="p-3">
                    {{ ($pengguna->currentPage() - 1) * $pengguna->perPage() + ($index + 1) }}
                </td>

                <td class="p-3">{{ $user->nama_pengguna }}</td>
                <td class="p-3">+62 {{ $user->no_telp }}</td>

                <td class="p-3">
                    <span class="px-3 py-1 rounded-full text-xs 
                        {{ $user->role == 'admin' ? 'bg-purple-200 text-purple-600' : 
                        ($user->role == 'operator' ? 'bg-blue-200 text-blue-600' : 
                        'bg-gray-200 text-gray-600') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>

                <td class="p-3 flex flex-wrap gap-2">
                    
                    <a href="{{ route('admin.pengguna.show', $user->id) }}"
                        class="px-3 py-1 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                        Detail
                    </a>

                    @if($user->role === 'customer')
                        <button class="px-3 py-1 bg-gray-300 text-gray-500 rounded-lg" disabled>Edit</button>
                    @else
                        <a href="{{ route('admin.pengguna.edit', $user->id) }}"
                            class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Edit
                        </a>
                    @endif

                    @if($user->role === 'customer' || $user->role === 'admin')
                        <button class="px-3 py-1 bg-gray-300 text-gray-500 rounded-lg" disabled>Hapus</button>
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
                    Data tidak ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>

    </table>
</div>

<div class="mt-5">
    {{ $pengguna->links() }}
</div>
