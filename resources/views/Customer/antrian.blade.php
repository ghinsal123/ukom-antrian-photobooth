<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Antrian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-50">

    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-400">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center">
                <a href="/dashboard" class="text-gray-600 hover:text-ppink-400">Dashboard</a>
                <a href="/antrian" class="text-pink-400 font-semibold">+ Antrian</a>
                <a href="/logout" class="text-gray-600 hover:text-pink-400">Logout</a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-10">

        <h2 class="text-3xl font-bold text-gray-800 mb-8">Form Tambah Antrian</h2>

        <div class="bg-white p-8 rounded-xl shadow-sm">

            <div class="space-y-6">

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                    <input 
                        type="text" 
                        class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                        placeholder="Masukkan nama anda"
                    >
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                    <input 
                        type="text" 
                        class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                        placeholder="Masukkan nomor telepon"
                    >
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Pilih Paket Foto</label>

                    <select 
                        class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                    >
                        <option value="">-- Pilih Paket Foto --</option>
                        <option value="hemat">Paket Hemat (1–2 orang)</option>
                        <option value="couple">Paket Couple (2 orang)</option>
                        <option value="family"> Paket Family (3–5 orang)</option>
                        <option value="premium"> Paket Premium (5-10 + Free Aksesoris)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Pilih Booth</label>

                    <select 
                        class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                    >
                        <option value="">-- Pilih Studio --</option>
                        <option value="A">Studio Vintage</option>
                        <option value="B">Studio Cream</option>
                        <option value="C">Studio Hitam</option>
                    </select>
                </div>

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
