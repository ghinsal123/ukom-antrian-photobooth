<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FlashFrame</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center p-6 bg-pink-50">

    <div class="w-full max-w-md">
        <div class="bg-white shadow-xl rounded-3xl p-10 relative overflow-hidden">

            <!-- Glow pastel -->
            <div class="absolute inset-0 -z-10 opacity-60 blur-xl bg-gradient-to-br from-[#FAD1E6] to-[#E5D4FF]"></div>

            <!-- Logo + Title -->
            <div class="text-center mb-6">
                <img src="<?php echo e(asset('images/logo.png')); ?>" 
                     alt="Logo" 
                     class="w-32 h-32 object-contain mx-auto mb-2 drop-shadow">

                <h1 class="text-3xl font-bold text-pink-400 tracking-wide mb-2">Login</h1>

                <p class="text-gray-600 text-sm leading-relaxed mx-4">
                    Masukkan nama Anda untuk mulai mengambil 
                    <span class="font-semibold text-pink-500">antrian photobooth</span>.
                </p>
            </div>

            <!-- FORM -->
            <form action="<?php echo e(route('customer.login.submit')); ?>" method="POST" class="space-y-5 mt-6">
                <?php echo csrf_field(); ?>

                <!-- Nama Lengkap -->
                <div>
                    <label class="font-semibold text-gray-700 mb-1 block">Nama Lengkap</label>

                    <input type="text" name="full_name" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50
                                  focus:ring-2 focus:ring-pink-400 focus:border-pink-400 outline-none transition">
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full py-3 rounded-xl text-white font-semibold shadow-md
                           bg-gradient-to-r from-pink-400 to-pink-500
                           hover:from-pink-500 hover:to-pink-600 transition">
                    Masuk ke Antrian
                </button>

            </form>

        </div>
    </div>

</body>
</html>
<?php /**PATH C:\ukom-antrian-photobooth\resources\views/customer/login.blade.php ENDPATH**/ ?>