<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Reservasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-50">

    <!-- Background Blur -->
    <div class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm"></div>

    <!-- Modal Card -->
    <div class="fixed inset-0 flex items-center justify-center px-4">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl p-6 relative">

            <!-- Tombol Close -->
            <a href="<?php echo e(route('customer.dashboard')); ?>"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl font-bold">
                ×
            </a>

            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Reservasi</h2>

            <!-- Nomor Antrian -->
            <div class="bg-pink-100 border-l-4 border-pink-400 p-3 rounded-lg mb-5">
                <p class="text-gray-600 text-sm">Nomor Antrian</p>
                <p class="text-lg font-bold text-pink-600">
                    <?php echo e($detail->kode ?? 'PB001'); ?>

                </p>
            </div>

            <!-- INFORMASI -->
            <div class="space-y-3">

                <div class="flex justify-between">
                    <span class="text-gray-600">Nama:</span>
                    <span class="font-semibold text-gray-800">
                        <?php echo e($detail->nama ?? 'Sarah Cantik'); ?>

                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Telepon:</span>
                    <span class="font-semibold text-gray-800">
                        <?php echo e($detail->telepon ?? '081234567890'); ?>

                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Jumlah Orang:</span>
                    <span class="font-semibold text-gray-800">
                        <?php echo e($detail->jumlah_orang ?? '2 Orang'); ?>

                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Booth:</span>
                    <span class="font-semibold text-gray-800">
                        <?php echo e($detail->booth ?? 'Studio A'); ?>

                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Tanggal:</span>
                    <span class="font-semibold text-gray-800">
                        <?php echo e($detail->tanggal ?? '2025-11-20'); ?>

                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span
                        class="px-3 py-1 text-sm rounded-full
                        <?php echo e(($detail->status ?? 'Dikonfirmasi') === 'Dikonfirmasi' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'); ?>">
                        <?php echo e($detail->status ?? 'Dikonfirmasi'); ?>

                    </span>
                </div>

            </div>

            <!-- Tombol Kembali -->
            <a href="<?php echo e(route('customer.dashboard')); ?>"
                class="block text-center bg-pink-400 hover:bg-pink-500 text-white px-4 py-2 rounded-xl mt-6">
                Kembali
            </a>

        </div>
    </div>

</body>

</html>
<?php /**PATH D:\belajarLaravel\ukomAntrianPhotobooth\resources\views/Customer/detail.blade.php ENDPATH**/ ?>