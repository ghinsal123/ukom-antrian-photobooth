<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Antrian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-400">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center">
                <a href="/dashboard" class="text-gray-600 hover:text-pink-400">Dashboard</a>
                <a href="/antrian" class="text-pink-400 font-semibold">+ Antrian</a>
                <a href="logout" class="text-gray-600 hover:text-pink-400">Logout</a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-10">

        <h2 class="text-3xl font-bold text-gray-800 mb-8">Form Tambah Antrian</h2>

        <div class="bg-white p-8 rounded-xl shadow-sm">

            <!-- FORM -->
            <div class="space-y-6">

                <!-- Nama -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                    <input 
                        type="text" 
                        class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                        placeholder="Contoh: Amanda Putri"
                    >
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                    <input 
                        type="text" 
                        class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                        placeholder="08xxxxxxxxxx"
                    >
                </div>

                <!-- Jumlah Orang -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Jumlah Orang</label>
                    <input 
                        type="number" 
                        class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                        placeholder="1 - 10 Orang"
                    >
                </div>

                <!-- Pilih Booth -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Pilih Booth</label>

                    <select 
                        class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                    >
                        <option value="">-- Pilih Studio --</option>
                        <option value="A">Studio A</option>
                        <option value="B">Studio B</option>
                        <option value="C">Studio C</option>
                    </select>
                </div>

                <!-- Nomor Antrian (Auto) -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nomor Antrian</label>
                    <input 
                        type="text"
                        disabled
                        class="w-full p-3 border rounded-lg bg-gray-100 text-gray-500"
                        placeholder="Otomatis berdasarkan booth"
                    >
                    <p class="text-sm text-gray-400 mt-1">
                        • Setiap studio punya nomor antrian sendiri.  
                        • Contoh: A001, A002, B001, C001, dst.
                    </p>
                </div>

                <!-- Tombol -->
                <div class="pt-4">
                    <button 
                        class="w-full bg-pink-400 text-white py-3 rounded-lg font-semibold hover:bg-pink-500 transition">
                        Tambah Antrian
                    </button>
                </div>

            </div>

        </div>

    </div>

</body>
</html>
<?php /**PATH D:\belajarLaravel\ukomAntrianPhotobooth\resources\views/Customer/antrian.blade.php ENDPATH**/ ?>