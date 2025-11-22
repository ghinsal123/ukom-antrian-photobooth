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
    <nav class="bg-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-pink-500">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center text-sm">
                <a href="<?php echo e(route('customer.dashboard')); ?>" class="text-pink-500 font-semibold">Dashboard</a>

                <a href="<?php echo e(route('customer.antrian')); ?>" class="hover:text-pink-500 text-gray-600">+ Antrian</a>

                <a href="#"
                   onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();"
                   class="hover:text-pink-500 text-gray-600">
                    Logout
                </a>

                <form id="logout-form" action="<?php echo e(route('customer.logout')); ?>" method="POST" class="hidden">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </div>
    </nav>

    <!-- FLASH MESSAGE -->
    <div class="max-w-6xl mx-auto px-4 mt-5">
        <?php if(session('success')): ?>
            <div class="alert bg-green-100 text-green-700"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('warning')): ?>
            <div class="alert bg-yellow-100 text-yellow-700"><?php echo e(session('warning')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert bg-red-100 text-red-700"><?php echo e(session('error')); ?></div>
        <?php endif; ?>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-6xl mx-auto px-4 py-10 space-y-10">

        <!-- GREETING -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h3 class="text-xl font-semibold text-gray-800">
                Halo, <?php echo e($pengguna->nama_pengguna); ?>

            </h3>
            <p class="text-gray-500 text-sm mt-1">Selamat datang di FlashFrame Photo Booth.</p>
        </div>

        <!-- ========================== -->
        <!-- TATA LETAK BARU DITUKAR -->
        <!-- ========================== -->

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ========================= -->
            <!-- KOLOM KIRI: ANTRIAN SAYA -->
            <!-- ========================= -->
            <div class="bg-white p-6 rounded-xl shadow-sm h-[380px] flex flex-col">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">Antrian Saya</h3>

                <?php if($antrianku->isEmpty()): ?>
                    <p class="text-center text-gray-500 py-5">Belum ada antrian.</p>
                <?php else: ?>

                    <div class="space-y-3 overflow-y-auto pr-1">
                        <?php $__currentLoopData = $antrianku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="rounded-lg border bg-pink-50 p-4">

                                <!-- INFO -->
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="text-sm font-semibold text-pink-600">
                                            Nomor Antrian: <?php echo e($item->nomor_antrian); ?>

                                            <span class="inline-block ml-2 w-2 h-2 rounded-full bg-pink-500"></span>
                                        </p>

                                        <p class="text-gray-600 text-xs">Paket: <?php echo e($item->paket->nama_paket); ?></p>
                                        <p class="text-gray-600 text-xs">Booth: <?php echo e($item->booth->nama_booth); ?></p>
                                        <p class="text-gray-600 text-xs">Tanggal: <?php echo e($item->tanggal); ?></p>
                                    </div>

                                    <div class="text-right">
                                        <?php if($item->status == 'menunggu'): ?>
                                            <span class="status-gray">Menunggu</span>
                                        <?php elseif($item->status == 'diproses'): ?>
                                            <span class="status-green">Diproses</span>
                                        <?php elseif($item->status == 'selesai'): ?>
                                            <span class="status-pink">Selesai</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- BUTTONS -->
                                <div class="flex gap-2 mt-2 flex-wrap">
                                    <a href="<?php echo e(route('customer.antrian.detail', $item->id)); ?>" class="btn-mini-blue">Detail</a>

                                    <?php if($item->status == 'menunggu'): ?>
                                        <a href="<?php echo e(route('customer.antrian.edit', $item->id)); ?>" class="btn-mini-yellow">Edit</a>

                                        <form action="<?php echo e(route('customer.antrian.delete', $item->id)); ?>" method="POST"
                                              onsubmit="return confirm('Yakin ingin membatalkan antrian ini?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn-mini-red">Batal</button>
                                        </form>
                                    <?php endif; ?>
                                </div>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                <?php endif; ?>
            </div>

            <!-- ============================= -->
            <!-- KOLOM KANAN: ANTRIAN PER BOOTH -->
            <!-- ============================= -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm">

                <h3 class="text-lg font-semibold text-gray-800 mb-4">Antrian Per Booth</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php $__currentLoopData = $booth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border p-4 rounded-lg bg-pink-50 h-72 flex flex-col">
                            <h4 class="text-center text-pink-600 font-bold mb-3"><?php echo e($bItem->nama_booth); ?></h4>

                            <?php if($bItem->antrian->isEmpty()): ?>
                                <p class="text-center text-gray-500 text-sm mt-auto mb-auto">Belum ada antrian.</p>
                            <?php else: ?>
                                <div class="space-y-2 overflow-y-auto">
                                    <?php $__currentLoopData = $bItem->antrian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="bg-white border p-3 rounded-lg">
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
                                                    <?php if($row->status == 'menunggu'): ?>
                                                        <span class="status-gray">Menunggu</span>
                                                    <?php elseif($row->status == 'diproses'): ?>
                                                        <span class="status-green">Diproses</span>
                                                    <?php elseif($row->status == 'selesai'): ?>
                                                        <span class="status-pink">Selesai</span>
                                                    <?php endif; ?>
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

    <!-- ========== STYLES ========== -->
    <style>
        .alert { padding: 10px; border-radius: 6px; font-size: 14px; margin-bottom: 10px; }

        /* STATUS COLORS */
        .status-gray { background:#e5e7eb; color:#374151; padding:3px 8px; border-radius:6px; font-size:11px; }
        .status-green { background:#22c55e; color:white; padding:3px 8px; border-radius:6px; font-size:11px; }
        .status-pink { background:#fbcfe8; color:#9d174d; padding:3px 8px; border-radius:6px; font-size:11px; }

        /* MINI BUTTONS */
        .btn-mini-blue {
            background:#dbeafe; color:#1e40af;
            padding:5px 9px; border-radius:6px; font-size:12px;
        }
        .btn-mini-yellow {
            background:#fef9c3; color:#92400e;
            padding:5px 9px; border-radius:6px; font-size:12px;
        }
        .btn-mini-red {
            background:#fee2e2; color:#991b1b;
            padding:5px 9px; border-radius:6px; font-size:12px;
        }

        .btn-mini-blue:hover,
        .btn-mini-yellow:hover,
        .btn-mini-red:hover { opacity:.9; }
    </style>

</body>
</html>
<?php /**PATH C:\Users\USER\ukom-antrian-photobooth\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>