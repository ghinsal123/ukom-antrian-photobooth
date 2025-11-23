<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Customer</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>

<body class="bg-pink-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-lg sm:text-xl font-bold text-pink-500">
                PhotoBooth FlashFrame
            </h1>

            <div class="hidden md:flex gap-6 items-center text-sm">
                <a href="<?php echo e(route('customer.dashboard')); ?>" class="text-pink-500 font-semibold">Dashboard</a>

                <a href="<?php echo e(route('customer.antrian')); ?>" class="text-gray-600 hover:text-pink-500">+ Antrian</a>

                <a href="<?php echo e(route('customer.arsip')); ?>" class="text-gray-600 hover:text-pink-500">Arsip</a>

                <a href="#"
                   onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();"
                   class="text-gray-600 hover:text-pink-500">
                    Logout
                </a>

                <form id="logout-form" action="<?php echo e(route('customer.logout')); ?>" method="POST" class="hidden">
                    <?php echo csrf_field(); ?>
                </form>
            </div>

            <button class="md:hidden text-2xl text-pink-500" onclick="toggleMenu()">☰</button>
        </div>

        <div id="mobileMenu" class="hidden md:hidden px-4 pb-4 space-y-2">
            <a href="<?php echo e(route('customer.dashboard')); ?>" class="block text-gray-700 hover:text-pink-500">Dashboard</a>
            <a href="<?php echo e(route('customer.antrian')); ?>" class="block text-gray-700 hover:text-pink-500">+ Antrian</a>
            <a href="<?php echo e(route('customer.arsip')); ?>" class="block text-gray-700 hover:text-pink-500">Arsip</a>
            <a href="#"
               onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();"
               class="block text-gray-700 hover:text-pink-500">
                Logout
            </a>
        </div>
    </nav>

    <script>
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
    </script>

    <div class="max-w-6xl mx-auto px-4 py-8 space-y-8">

        <!-- SAPAAN -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h3 class="text-lg sm:text-xl font-semibold text-gray-800">
                Halo, <?php echo e($pengguna->nama_pengguna); ?>

            </h3>
            <p class="text-gray-500 text-sm mt-1">Selamat datang di FlashFrame Photo Booth.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ANTRIAN SAYA -->
            <div class="bg-white p-6 rounded-xl shadow-sm flex flex-col">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Antrian Saya</h3>

                <?php
                    $antrianAktif = $antrianku->filter(function($x) {
                        return in_array(strtolower($x->status), ['menunggu','proses','diproses']);
                    });
                ?>

                <?php if($antrianAktif->isEmpty()): ?>
                    <p class="text-center text-gray-500 py-5">Belum ada antrian aktif.</p>
                <?php else: ?>
                    <div class="space-y-3 flex-1">
                        <?php $__currentLoopData = $antrianAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $status = strtolower($item->status); ?>

                            <div class="rounded-lg border bg-pink-50 p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="text-sm font-semibold text-pink-600">
                                            Nomor Antrian: <?php echo e($item->nomor_antrian); ?>

                                        </p>
                                        <p class="text-gray-600 text-xs">Paket: <?php echo e($item->paket->nama_paket); ?></p>
                                        <p class="text-gray-600 text-xs">Booth: <?php echo e($item->booth->nama_booth); ?></p>
                                        <p class="text-gray-600 text-xs">Tanggal: <?php echo e($item->tanggal); ?></p>
                                    </div>

                                    <div class="text-right">
                                        <?php if($status == 'menunggu'): ?>
                                            <span class="px-2 py-0.5 bg-gray-200 text-gray-700 text-[11px] rounded-md">Menunggu</span>
                                        <?php elseif($status == 'proses' || $status == 'diproses'): ?>
                                            <span class="px-2 py-0.5 bg-green-500 text-white text-[11px] rounded-md">Diproses</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="flex gap-2 mt-2 flex-wrap">
                                    <a href="<?php echo e(route('customer.antrian.detail', $item->id)); ?>"
                                       class="px-3 py-1 text-xs rounded-md bg-blue-100 text-blue-800">
                                        Detail
                                    </a>

                                    <?php if($status == 'menunggu'): ?>
                                        <a href="<?php echo e(route('customer.antrian.edit', $item->id)); ?>"
                                           class="px-3 py-1 text-xs rounded-md bg-yellow-100 text-yellow-800">
                                            Edit
                                        </a>

                                        <form action="<?php echo e(route('customer.antrian.delete', $item->id)); ?>" method="POST"
                                              onsubmit="return confirm('Yakin ingin membatalkan antrian ini?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                    class="px-3 py-1 text-xs rounded-md bg-red-100 text-red-700">
                                                Batal
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- ANTRIAN PER BOOTH -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Antrian Per Booth</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php $__currentLoopData = $booth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="border p-4 rounded-lg bg-pink-50 h-auto flex flex-col">
                            <h4 class="text-center text-pink-600 font-bold mb-3"><?php echo e($bItem->nama_booth); ?></h4>

                            <?php
                                $list = $bItem->antrian->filter(function($r) {
                                    return in_array(strtolower($r->status), [
                                        'menunggu','proses','diproses','selesai','dibatalkan'
                                    ]);
                                });
                            ?>

                            <?php if($list->isEmpty()): ?>
                                <p class="text-center text-gray-500 text-sm my-auto">Belum ada antrian.</p>
                            <?php else: ?>
                                <div class="space-y-2 flex-1">

                                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $status = strtolower($row->status);

                                            // TANPA TERNARY BERTUMPUK → AMAN PHP 8
                                            if ($status === 'selesai') {
                                                $wrapperClass = 'opacity-50 bg-gray-200';
                                            } elseif ($status === 'dibatalkan') {
                                                $wrapperClass = 'opacity-50 bg-red-200';
                                            } else {
                                                $wrapperClass = 'bg-white';
                                            }
                                        ?>

                                        <div class="border p-3 rounded-lg <?php echo e($wrapperClass); ?>">
                                            <div class="flex justify-between items-start">

                                                <div>
                                                    <p class="text-sm font-semibold">
                                                        #<?php echo e($row->nomor_antrian); ?>


                                                        <?php if($row->pengguna_id == session('customer_id')): ?>
                                                            <span class="inline-block ml-2 w-2 h-2 rounded-full bg-pink-500"></span>
                                                        <?php endif; ?>
                                                    </p>

                                                    <p class="text-xs text-gray-600">Paket: <?php echo e($row->paket->nama_paket); ?></p>
                                                    <p class="text-xs text-gray-600">Nama: <?php echo e($row->pengguna->nama_pengguna); ?></p>
                                                </div>

                                                <div>
                                                    <span class="px-2 py-0.5 text-[11px] rounded-md
                                                        <?php if($status=='menunggu'): ?> bg-gray-200 text-gray-700
                                                        <?php elseif($status=='proses'||$status=='diproses'): ?> bg-green-500 text-white
                                                        <?php elseif($status=='selesai'): ?> bg-gray-500 text-white
                                                        <?php else: ?> bg-red-600 text-white
                                                        <?php endif; ?>">
                                                        <?php echo e(ucfirst($row->status)); ?>

                                                    </span>
                                                </div>

                                            </div>
                                        </div>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
<?php /**PATH C:\Users\USER\ukom-antrian-photobooth\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>