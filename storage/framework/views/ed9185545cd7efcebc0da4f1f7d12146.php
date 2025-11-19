<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Antrian</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>

<body class="bg-pink-50">

    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-400">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center">
                <a href="/customer/dashboard" class="text-gray-600 hover:text-pink-400">Dashboard</a>
                <a href="/customer/antrian" class="text-pink-400 font-semibold">+ Antrian</a>

                <a href="#"
                    onclick="event.preventDefault(); 
                    if (confirm('Apakah Anda yakin ingin logout?')) {
                        document.getElementById('logout-form').submit();
                    }"
                    class="text-gray-600 hover:text-pink-400">
                    Logout
                </a>

                <form id="logout-form" action="<?php echo e(route('customer.logout')); ?>" method="POST" class="hidden">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-10">

        <h2 class="text-3xl font-bold text-gray-800 mb-8">Form Tambah Antrian</h2>

        <div class="bg-white p-8 rounded-xl shadow-sm">
            <form action="<?php echo e(route('customer.antrian.submit')); ?>" method="POST">

                <?php echo csrf_field(); ?>

                <div class="space-y-6">
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                        <input 
                            type="text" 
                            name="nama_lengkap"
                            value="<?php echo e(old('nama_lengkap')); ?>"
                            class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                            placeholder="Masukkan nama anda"
                            required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                        <input 
                            type="text" 
                            name="no_telp"
                            value="<?php echo e(old('no_telp')); ?>"
                            class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                            placeholder="Masukkan nomor telepon"
                            required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Pilih Paket Foto</label>
                        <select 
                            name="paket_id"
                            class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                            required>
                            <option value="1">Paket Hemat</option>
                            <option value="2">Paket Couple</option>
                            <option value="3">Paket Family</option>
                            <option value="4">Paket Premium</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Pilih Booth</label>
                        <select 
                            name="booth_id"
                            class="w-full p-3 border rounded-lg focus:ring-pink-300 focus:border-pink-400"
                            required>
                            <option value="1">Booth Vintage</option>
                            <option value="2">Booth Classic</option>
                            <option value="3">Booth Modern</option>
                            <option value="4">Booth Minimal</option>
                            <option value="5">Booth Neutral</option>
                        </select>
                    </div>

                    <div class="pt-4">
                        <button 
                            type="submit"
                            class="w-full bg-pink-400 text-white py-3 rounded-lg font-semibold hover:bg-pink-500 transition">
                            Tambah Antrian
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\USER\ukom-antrian-photobooth\resources\views/customer/antrian.blade.php ENDPATH**/ ?>