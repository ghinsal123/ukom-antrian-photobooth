<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Operator | FlashFrame</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center p-6 bg-pink-50">

    <div class="w-full max-w-md">
        <div class="bg-white shadow-xl rounded-3xl p-10 relative overflow-hidden">
            <div class="absolute inset-0 -z-10 opacity-60 blur-xl bg-linear-to-br from-[#FAD1E6] to-[#E5D4FF]"></div>

            <!-- logo dan judul -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Logo" 
                     class="w-32 h-32 object-contain mx-auto mb-2 drop-shadow">

                <h1 class="text-3xl font-bold text-pink-400 tracking-wide mb-2">Login Operator</h1>

                <p class="text-gray-600 text-sm leading-relaxed mx-4">
                    Masukkan nama dan password operator
                    <span class="font-semibold text-pink-500">untuk mengelola sistem Photobooth</span>.
                </p>
            </div>

            <!-- form login -->
            <form action="{{ route('operator.login.submit') }}" method="POST" class="space-y-5 mt-6">
                @csrf

                <!-- input username -->
                <div>
                    <label class="font-semibold text-gray-700 mb-1 block">Nama Operator</label>

                    <input type="text" name="username" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50
                                  focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                </div>

                <!-- input password  -->
                <div>
                    <label class="font-semibold text-gray-700 mb-1 block">Password</label>

                    <div class="relative">
                        <input type="password" name="password" id="passwordInput" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50
                            focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition"
                            placeholder="Masukkan password">

                        <!-- icon show/hide password -->
                        <span onclick="togglePassword()" 
                            class="absolute right-4 top-3.5 cursor-pointer select-none">
                            <img id="eyeOpen" src="{{ asset('images/eye.png') }}" class="w-5 h-5 hidden">
                            <img id="eyeClosed" src="{{ asset('images/hidden.png') }}" class="w-5 h-5">
                        </span>
                    </div>
                </div>

                <!-- tombol login -->
                <button type="submit"
                    class="w-full py-3 rounded-xl text-white font-semibold shadow-md
                           bg-linear-to-r from-pink-400 to-pink-500
                           hover:from-pink-500 hover:to-pink-600 transition">
                    Login Operator
                </button>

            </form>

        </div>
    </div>

    <!-- script toggle password -->
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
