<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - FlashFrame</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50 min-h-screen">

    <div class="max-w-lg mx-auto my-10 bg-white p-8 rounded-2xl shadow-lg border border-pink-100">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-pink-600 mb-2">Edit Profil</h1>
            <p class="text-gray-600">Perbarui foto profil Anda</p>
        </div>

        <form action="{{ route('customer.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Foto Profil Saat Ini -->
            <div class="mb-6 text-center">
                <div class="relative inline-block">
                    @if($pengguna->foto && file_exists(public_path('pengguna/' . $pengguna->foto)))
                        <img id="previewImage" 
                             src="{{ asset('pengguna/' . $pengguna->foto) }}" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-pink-100 shadow-md">
                    @else
                        <div class="w-32 h-32 rounded-full bg-pink-100 border-4 border-pink-100 flex items-center justify-center text-pink-500 text-4xl font-bold shadow-md">
                            {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                        </div>
                    @endif
                    
                    <!-- Tombol Ubah Foto -->
                    <label for="foto" class="absolute bottom-0 right-0 bg-pink-500 hover:bg-pink-600 text-white p-2 rounded-full cursor-pointer shadow-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </label>
                </div>
                
                <p class="text-sm text-gray-500 mt-3">
                    Klik ikon kamera untuk mengubah foto
                </p>
            </div>

            <!-- Input File (Hidden) -->
            <div class="mb-6">
                <input type="file" name="foto" id="foto" accept="image/*" class="hidden">
                
                @error('foto')
                    <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                @enderror
                
                <!-- Info Ukuran File -->
                <p class="text-xs text-gray-500 text-center mt-1">
                    Format: JPG, JPEG, PNG (Max: 2MB)
                </p>
            </div>

            <!-- Informasi Pengguna (Readonly) -->
            <div class="space-y-4 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" value="{{ $pengguna->nama_pengguna }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed" readonly>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" value="{{ $pengguna->email }}" 
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed" readonly>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex gap-4">
                <a href="{{ route('customer.landingpage') }}" 
                   class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-lg text-center font-medium hover:bg-gray-200 transition-colors">
                    Kembali
                </a>
                
                <button type="submit" 
                        class="flex-1 px-4 py-3 bg-pink-500 text-white rounded-lg font-medium hover:bg-pink-600 transition-colors shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Script Preview Foto -->
    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    
                    // Ubah div avatar jadi img jika sebelumnya pakai avatar
                    const previewElement = document.getElementById('previewImage');
                    if (previewElement.tagName === 'DIV') {
                        const newImg = document.createElement('img');
                        newImg.id = 'previewImage';
                        newImg.src = e.target.result;
                        newImg.className = 'w-32 h-32 rounded-full object-cover border-4 border-pink-100 shadow-md';
                        previewElement.parentNode.replaceChild(newImg, previewElement);
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>
</html>