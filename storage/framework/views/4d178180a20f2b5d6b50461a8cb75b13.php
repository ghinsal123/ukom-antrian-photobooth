<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Antrian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-50">

    <div class="max-w-xl mx-auto px-4 py-10">

        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Antrian</h1>

        <div class="bg-white rounded-xl shadow p-6 space-y-5">

            <label class="block">
                <span class="text-gray-700">Nama</span>
                <input class="w-full mt-1 px-3 py-2 border rounded-lg" value="Stephanie">
            </label>

            <label class="block">
                <span class="text-gray-700">Nomor Telepon</span>
                <input class="w-full mt-1 px-3 py-2 border rounded-lg" value="08123456789">
            </label>

            <label class="block">
                <span class="text-gray-700">Jumlah Orang</span>
                <input type="number" class="w-full mt-1 px-3 py-2 border rounded-lg" value="2">
            </label>

            <label class="block">
                <span class="text-gray-700">Booth</span>
                <select class="w-full mt-1 px-3 py-2 border rounded-lg">
                    <option selected>Studio A</option>
                    <option>Studio B</option>
                    <option>Studio C</option>
                </select>
            </label>

            <button class="w-full bg-pink-400 hover:bg-pink-500 text-white py-3 rounded-xl">
                Simpan Perubahan
            </button>

        </div>

    </div>

</body>
</html>
<?php /**PATH C:\ukom-antrian-photobooth\resources\views/Customer/edit.blade.php ENDPATH**/ ?>