<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Antrian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-50">

    <div class="max-w-lg mx-auto px-4 py-16">

        <div class="bg-white shadow p-8 rounded-2xl text-center">

            <h1 class="text-2xl font-bold text-gray-800 mb-4">Hapus Antrian?</h1>

            <p class="text-gray-600 mb-6">
                Apakah kamu yakin ingin menghapus antrian  
                <span class="font-semibold text-pink-500">A003 — Stephanie</span>?
                <br>
                Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex justify-center gap-4 mt-6">

                <!-- Cancel -->
                <a href="/customer/activity"
                   class="px-6 py-3 rounded-xl bg-gray-200 text-gray-800 font-semibold hover:bg-gray-300">
                    Batal
                </a>

                <!-- Confirm Delete -->
                <button
                    onclick="window.location.href='/customer/activity'"
                    class="px-6 py-3 rounded-xl bg-red-500 text-white font-semibold hover:bg-red-600">
                    Hapus
                </button>
            </div>

        </div>

    </div>

</body>
</html>
<?php /**PATH D:\belajarLaravel\ukomAntrianPhotobooth\resources\views/Customer/hapus.blade.php ENDPATH**/ ?>