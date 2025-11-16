<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            
            <h1 class="text-2xl font-bold text-pink-400">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center">
                <a href="<?php echo e(route('customer.dashboard')); ?>" class="text-pink-400 font-semibold">Dashboard</a>
                <a href="<?php echo e(route('customer.antrian')); ?>" class="text-gray-600 hover:text-pink-400">+ Antrian</a>
                <a href="<?php echo e(route('customer.logout')); ?>" class="text-gray-600 hover:text-pink-400">Logout</a>
            </div>
        </div>
    </nav>

   <div class="max-w-6xl mx-auto px-4 py-8">

    <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>

    <p class="text-lg text-gray-700 font-semibold mt-1 mb-6">
       Halo, <?php echo e($nama); ?>

    </p>

    <!-- ANTRIAN PER BOOTH -->
    <h3 class="text-2xl font-bold text-gray-800 mb-4">Antrian Per Booth</h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <!-- Booth Vintage -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Vintage</h4>
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span class="font-semibold text-gray-800">VT001 — Sarah</span>
                    <span class="text-gray-500 text-sm">Menunggu</span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="font-semibold text-gray-800">VT002 — Andi</span>
                    <span class="text-gray-500 text-sm">Menunggu</span>
                </div>
            </div>
        </div>

        <!-- Booth Classic -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Classic</h4>
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span class="font-semibold text-gray-800">CL001 — Bella</span>
                    <span class="text-gray-500 text-sm">Sedang Foto</span>
                </div>

                <div class="flex justify-between border-b pb-2">
                    <span class="font-semibold text-gray-800">CL002 — Roni</span>
                    <span class="text-gray-500 text-sm">Menunggu</span>
                </div>
            </div>
        </div>

        <!-- Booth Minimal -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Minimal</h4>
            <div class="space-y-3">
                <div class="flex justify-between border-b pb-2">
                    <span class="font-semibold text-gray-800">MN001 — Kevin</span>
                    <span class="text-gray-500 text-sm">Menunggu</span>
                </div>
                <p class="text-gray-400 text-sm italic mt-2">Belum ada antrian lain</p>
            </div>
        </div>

        <!-- Booth Modern -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Modern</h4>
            <div class="space-y-3">
                <p class="text-gray-400 text-sm italic mt-2">Belum ada antrian</p>
            </div>
        </div>

        <!-- Booth Neutral -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Neutral</h4>
            <div class="space-y-3">
                <p class="text-gray-400 text-sm italic mt-2">Belum ada antrian</p>
            </div>
        </div>

        <!-- Booth Bright -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Bright</h4>
            <div class="space-y-3">
                <p class="text-gray-400 text-sm italic mt-2">Belum ada antrian</p>
            </div>
        </div>

    </div>

    <!-- AKTIVITAS KAMU -->
    <h3 class="text-2xl font-bold text-gray-800 mb-4">Aktivitas Kamu</h3>

    <div class="bg-white p-6 rounded-xl shadow-sm space-y-6">

        <!-- ITEM 1 -->
        <div class="border-b pb-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-800">VT003 — Stephanie</p>
                    <p class="text-sm text-gray-500">Booth Vintage • Menunggu</p>
                </div>

                <div class="flex gap-4">
                    <a href="<?php echo e(route('customer.activity.detail', 3)); ?>" class="text-blue-500 font-semibold text-sm hover:underline">Detail</a>
                    <a href="<?php echo e(route('customer.activity.edit', 3)); ?>" class="text-yellow-500 font-semibold text-sm hover:underline">Edit</a>
                    <a href="/customer/activity/3/delete" class="text-red-500 font-semibold text-sm hover:underline">Delete</a>
                </div>
            </div>
        </div>

        <!-- ITEM 2 -->
        <div>
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-800">MN002 — Dwi</p>
                    <p class="text-sm text-gray-500">Booth Minimal • Menunggu</p>
                </div>

                <div class="flex gap-4">
                    <a href="<?php echo e(route('customer.activity.detail', 2)); ?>" class="text-blue-500 font-semibold text-sm hover:underline">Detail</a>
                    <a href="<?php echo e(route('customer.activity.edit', 2)); ?>" class="text-yellow-500 font-semibold text-sm hover:underline">Edit</a>
                    <a href="/customer/activity/2/delete" class="text-red-500 font-semibold text-sm hover:underline">Delete</a>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>
<?php /**PATH C:\ukom-antrian-photobooth\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>