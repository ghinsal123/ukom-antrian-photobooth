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

            <!-- Glow pastel -->
            <div class="absolute inset-0 -z-10 opacity-60 blur-xl bg-linear-to-br from-[#FAD1E6] to-[#E5D4FF]"></div>

            <!-- Logo + Title -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Logo" 
                     class="w-32 h-32 object-contain mx-auto mb-2 drop-shadow">

                <h1 class="text-3xl font-bold text-pink-400 tracking-wide mb-2">Login Admin</h1>

                <p class="text-gray-600 text-sm leading-relaxed mx-4">
                    Masukkan kredensial admin untuk
                    <span class="font-semibold text-pink-500">mengelola sistem Photobooth</span>.
                </p>
            </div>

            <!-- FORM -->
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-5 mt-6">
                @csrf

                <!-- Username -->
                <div>
                    <label class="font-semibold text-gray-700 mb-1 block">Username</label>

                    <input type="text" name="username" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50
                                  focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition"
                           placeholder="Masukkan username">
                </div>

                <!-- Password -->
                <div>
                    <label class="font-semibold text-gray-700 mb-1 block">Password</label>

                    <input type="password" name="password" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50
                                  focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition"
                           placeholder="Masukkan password">
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full py-3 rounded-xl text-white font-semibold shadow-md
                           bg-linear-to-r from-pink-400 to-pink-500
                           hover:from-pink-500 hover:to-pink-600 transition">
                    Login Admin
                </button>

            </form>

        </div>
    </div>

</body>
</html>
