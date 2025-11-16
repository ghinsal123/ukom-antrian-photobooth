<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Photobooth Reservation</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white w-[350px] md:w-[400px] p-8 rounded-2xl shadow-lg text-center">
        
        
        <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-r from-pink-400 to-purple-500 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 7h2l2-3h10l2 3h2v12H3V7z"/>
            </svg>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold mt-4 text-gray-800">Admin Portal</h1>
        <p class="text-gray-500 text-sm -mt-1 mb-6">Photobooth Reservation System</p>

        
        <form method="POST" action="<?php echo e(route('admin.login')); ?>">
            <?php echo csrf_field(); ?>

            <div class="text-left mb-4">
                <label class="font-semibold text-gray-700">Username</label>
                <input type="text" name="username"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-400 outline-none"
                       placeholder="Masukkan username">
            </div>

            <div class="text-left mb-4">
                <label class="font-semibold text-gray-700">Password</label>
                <input type="password" name="password"
                       class="w-full mt-1 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-400 outline-none"
                       placeholder="Masukkan password">
            </div>

            <button type="submit"
                class="w-full mt-2 bg-gradient-to-r from-pink-500 to-purple-500 text-white py-2 rounded-lg font-semibold hover:opacity-90 transition">
                Login
            </button>
        </form>
    </div>

</body>
</html>
<?php /**PATH D:\belajarLaravel\ukomAntrianPhotobooth\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>