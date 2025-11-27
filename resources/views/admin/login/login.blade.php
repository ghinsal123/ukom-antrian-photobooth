<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        {{-- Judul halaman --}}
        <title>Login Admin | FlashFrame</title>

        {{-- Load file CSS dari Vite --}}
        @vite('resources/css/app.css')
    </head>

    {{-- Background halaman login --}}
    <body class="min-h-screen flex items-center justify-center p-6 bg-pink-50">

        <div class="w-full max-w-md">

            {{-- Card utama form login --}}
            <div class="bg-white shadow-xl rounded-3xl p-10 relative overflow-hidden">

                {{-- Efek background blur dekoratif --}}
                <div class="absolute inset-0 -z-10 opacity-60 blur-xl bg-linear-to-br from-[#FAD1E6] to-[#E5D4FF]"></div>

                {{-- Bagian header: logo + judul --}}
                <div class="text-center mb-6">
                    {{-- Logo aplikasi --}}
                    <img src="{{ asset('images/logo.png') }}" class="w-32 h-32 mx-auto mb-2">

                    {{-- Judul halaman --}}
                    <h1 class="text-3xl font-bold text-pink-400 mb-2">Login Admin</h1>

                    {{-- Deskripsi login --}}
                    <p class="text-gray-600 text-sm leading-relaxed mx-4">
                        Masukkan nama dan password admin 
                        <span class="font-semibold text-pink-500">untuk mengelola sistem Photobooth</span>.
                    </p>
                </div>

                {{-- Alert error login (jika data salah) --}}
                @if($errors->has('login'))
                    <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                {{-- Form login --}}
                <form action="{{ route('admin.login') }}" method="POST" class="space-y-5 mt-6">
                    @csrf

                    {{-- Input Username --}}
                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">Username</label>

                        <input 
                            type="text" 
                            name="username" 
                            value="{{ old('username') }}" 
                            required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50
                            focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition"
                            placeholder="Masukkan username">
                    </div>

                    {{-- Input Password + icon show/hide --}}
                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">Password</label>

                        <div class="relative">

                            {{-- Input password --}}
                            <input 
                                type="password" 
                                name="password" 
                                id="passwordInput" 
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50
                                focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition"
                                placeholder="Masukkan password">

                            {{-- Icon mata untuk toggle password --}}
                            <span onclick="togglePassword()" 
                                class="absolute right-4 top-3.5 cursor-pointer select-none">

                                {{-- Icon mata terbuka (awal: hidden) --}}
                                <img id="eyeOpen" src="{{ asset('images/eye.png') }}" 
                                    class="w-5 h-5 hidden">

                                {{-- Icon mata tertutup (default tampil) --}}
                                <img id="eyeClosed" src="{{ asset('images/hidden.png') }}" 
                                    class="w-5 h-5">
                            </span>
                        </div>
                    </div>

                    {{-- Tombol submit login --}}
                    <button type="submit"
                        class="w-full py-3 rounded-xl text-white font-semibold shadow-md
                        bg-linear-to-r from-pink-400 to-pink-500
                        hover:from-pink-500 hover:to-pink-600 transition">
                        Login Admin
                    </button>

                </form>

            </div>
        </div>

        {{-- Script toggle show/hide password --}}
        <script>
            function togglePassword() {
                const input = document.getElementById('passwordInput');
                const eyeOpen = document.getElementById('eyeOpen');
                const eyeClosed = document.getElementById('eyeClosed');

                const isHidden = input.type === 'password';

                input.type = isHidden ? 'text' : 'password';

                eyeOpen.classList.toggle('hidden', !isHidden);
                eyeClosed.classList.toggle('hidden', isHidden);
            }
        </script>
    </body>
</html>
