<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50 min-h-screen">

    <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-5">Edit Profil</h2>

        <form action="{{ route('customer.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- NAMA (READONLY) -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-medium">Nama Pengguna</label>
                <input type="text"
                       value="{{ $pengguna->nama_pengguna }}"
                       class="border w-full p-2 rounded-lg mt-1 bg-gray-100 cursor-not-allowed"
                       readonly>
            </div>

            <!-- FOTO SAAT INI -->
            <div class="mb-4">
                <label class="block mb-2 font-medium text-gray-700">Foto Profil Saat Ini</label>

                <img src="{{ $pengguna->foto 
                    ? asset('storage/' . $pengguna->foto) 
                    : 'https://ui-avatars.com/api/?name=' . urlencode($pengguna->nama_pengguna) }}"
                    class="w-28 h-28 rounded-full object-cover border mx-auto mb-3">
            </div>

            <!-- UPLOAD FOTO BARU -->
            <div class="mb-4">
                <label class="block mb-2 font-medium text-gray-700">Upload Foto Baru</label>

                <input type="file" name="foto" accept="image/*"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-300">

                @error('foto')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- BUTTON -->
            <div class="flex justify-between">
                <a href="{{ route('customer.dashboard') }}"
                   class="px-4 py-2 bg-gray-300 rounded-lg">Kembali</a>

                <button type="submit"
                        class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</body>
</html>
