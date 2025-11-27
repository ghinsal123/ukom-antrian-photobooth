<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FlashFrame</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="relative p-8 sm:p-10 bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="absolute inset-0 -z-10 bg-gradient-to-br from-pink-200/60 to-purple-200/60 blur-xl"></div>

            {{-- logo & judul login --}}
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Logo"
                     class="w-28 h-28 sm:w-32 sm:h-32 mx-auto object-contain drop-shadow mb-2">
                <h1 class="text-3xl font-bold text-pink-400 tracking-wide mb-2">Login</h1>
                <p class="text-gray-600 text-sm leading-relaxed mx-2 sm:mx-4">
                    Masukkan nama & no telepon kamu untuk ambil
                    <span class="font-semibold text-pink-500">antrian photobooth</span>.  
                </p>
            </div>

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- form login --}}
            <form action="{{ route('customer.login.submit') }}" method="POST" class="space-y-5 mt-6">
                @csrf

                {{-- Input Nama Lengkap --}}
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" 
                           name="full_name" 
                           value="{{ old('full_name') }}"
                           required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                           focus:border-pink-400 focus:ring-2 focus:ring-pink-400 outline-none transition
                           text-sm sm:text-base"
                           placeholder="Masukkan nama kamu">
                </div>

                {{-- Input Nomor Telepon --}}
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Nomor Telepon</label>
                    <input type="text" 
                           name="no_telp" 
                           value="{{ old('no_telp') }}"
                           required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl
                           focus:border-pink-400 focus:ring-2 focus:ring-pink-400 outline-none transition
                           text-sm sm:text-base"
                           placeholder="Masukkan nomor telepon">
                </div>

                {{-- Tombol login --}}
                <button type="submit"
                    class="w-full py-3 font-semibold text-white rounded-xl shadow-md
                    bg-gradient-to-r from-pink-400 to-pink-500
                    hover:from-pink-500 hover:to-pink-600 transition text-sm sm:text-base">
                    Masuk ke Antrian
                </button>
            </form>

        </div>
    </div>
</body>
</html>
