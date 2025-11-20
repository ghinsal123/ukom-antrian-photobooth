<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Admin | FlashFrame</title>
        @vite('resources/css/app.css')
    </head>

    <body class="min-h-screen flex items-center justify-center p-6 bg-pink-50">

        <div class="w-full max-w-md">
            <div class="bg-white shadow-xl rounded-3xl p-10 relative overflow-hidden">

                <div class="absolute inset-0 -z-10 opacity-60 blur-xl bg-linear-to-br from-[#FAD1E6] to-[#E5D4FF]"></div>

                <div class="text-center mb-6">
                    <img src="{{ asset('images/logo.png') }}" class="w-32 h-32 mx-auto mb-2">
                    <h1 class="text-3xl font-bold text-pink-400 mb-2">Login Admin</h1>
                    <p class="text-gray-600 text-sm">Masukkan kredensial admin untuk mengelola sistem Photobooth.</p>
                </div>

                <!-- ALERT ERROR -->
                @if($errors->has('login'))
                    <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                <form action="{{ route('admin.login') }}" method="POST" class="space-y-5 mt-6">
                    @csrf

                    <!-- USERNAME -->
                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50
                            focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition"
                            placeholder="Masukkan username">
                    </div>

                    <!-- PASSWORD + ICON MATA -->
                    <div>
                        <label class="font-semibold text-gray-700 mb-1 block">Password</label>

                        <div class="relative">
                            <input type="password" name="password" id="passwordInput" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50
                                focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition"
                                placeholder="Masukkan password">

                            <span onclick="togglePassword()" 
                                class="absolute right-4 top-3.5 cursor-pointer select-none">

                                <!-- MATA TERBUKA (disembunyikan dulu) -->
                                <img id="eyeOpen" src="{{ asset('images/eye.png') }}" 
                                    class="w-5 h-5 hidden">

                                <!-- MATA TERTUTUP (default muncul) -->
                                <img id="eyeClosed" src="{{ asset('images/hidden.png') }}" 
                                    class="w-5 h-5">
                            </span>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full py-3 rounded-xl text-white font-semibold shadow-md
                        bg-linear-to-r from-pink-400 to-pink-500
                        hover:from-pink-500 hover:to-pink-600 transition">
                        Login Admin
                    </button>

                </form>

            </div>
        </div>

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