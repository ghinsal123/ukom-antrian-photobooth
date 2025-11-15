<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-50 flex items-center justify-center min-h-screen p-6">

    <div class="bg-white shadow-lg rounded-3xl p-10 w-full max-w-md text-center">

        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-20 h-20 text-pink-400" 
                 fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
            </svg>
        </div>

        <!-- Text -->
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Yakin ingin Logout?</h2>
        <p class="text-gray-600 mb-8">
            Kamu akan keluar dari akun dan kembali ke halaman login.
        </p>

        <!-- Buttons -->
        <div class="space-y-3">

            <a href="/customer/login" 
               class="block w-full bg-pink-400 hover:bg-pink-500 text-white py-3 rounded-xl font-semibold transition">
                Logout Sekarang
            </a>

            <a href="/customer/dashboard" 
               class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-xl font-medium transition">
                Batal
            </a>
        </div>

    </div>

</body>
</html>
<?php /**PATH C:\ukom-antrian-photobooth\resources\views/Customer/logout.blade.php ENDPATH**/ ?>