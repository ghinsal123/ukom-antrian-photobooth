<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>

<body class="bg-pink-50">

    
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-400">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center">
                <a href="/customer/dashboard" class="text-pink-400 font-semibold">Dashboard</a>
                <a href="/customer/antrian" class="text-gray-600 hover:text-pink-400">+ Antrian</a>

                <a href="#"
                    onclick="event.preventDefault(); 
                    if (confirm('Yakin ingin logout?')) {
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

    <div class="max-w-6xl mx-auto px-4 py-10">

        <h2 class="text-3xl font-bold text-gray-800 mb-8">Dashboard Customer</h2>

        
        <div class="bg-white p-6 rounded-xl shadow-sm mb-8">
            <h3 class="text-xl font-bold text-gray-700 mb-2">Halo, <?php echo e($nama); ?> 👋</h3>
            <p class="text-gray-600">Berikut antrian kamu dan daftar antrian pada tiap booth.</p>
        </div>


        
        <div class="bg-white p-8 rounded-xl shadow-sm mb-12">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Antrian Saya</h3>

            <?php if($antrianku->isEmpty()): ?>
                <p class="text-gray-600 text-center py-10">Belum ada antrian yang kamu buat.</p>
            <?php else: ?>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-pink-200 text-gray-700">
                            <th class="p-3">Nomor</th>
                            <th class="p-3">Paket</th>
                            <th class="p-3">Booth</th>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $__currentLoopData = $antrianku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-t">
                                <td class="p-3 font-semibold"><?php echo e($item->nomor_antrian); ?></td>
                                <td class="p-3"><?php echo e($item->paket->nama_paket ?? '-'); ?></td>
                                <td class="p-3"><?php echo e($item->booth->nama_booth ?? '-'); ?></td>
                                <td class="p-3"><?php echo e($item->tanggal); ?></td>
                                <td class="p-3">
                                    <span class="px-3 py-1 rounded-full text-white 
                                        <?php if($item->status == 'menunggu'): ?> bg-yellow-500 
                                        <?php elseif($item->status == 'diproses'): ?> bg-blue-500 
                                        <?php else: ?> bg-green-500 <?php endif; ?>">
                                        <?php echo e(ucfirst($item->status)); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>
            <?php endif; ?>
        </div>



        
        <div class="bg-white p-8 rounded-xl shadow-sm">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">Antrian Per Booth</h3>

            <?php $__currentLoopData = $booths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-10">
                    <h4 class="text-xl font-bold text-pink-500 mb-3"><?php echo e($booth->nama_booth); ?></h4>

                    <?php if($antrianBooth[$booth->id]->isEmpty()): ?>
                        <p class="text-gray-500 italic">Belum ada antrian di booth ini.</p>
                    <?php else: ?>
                        <table class="w-full text-left border-collapse mb-6">
                            <thead>
                                <tr class="bg-gray-200 text-gray-700">
                                    <th class="p-3">Nomor</th>
                                    <th class="p-3">Nama Pengguna</th>
                                    <th class="p-3">Paket</th>
                                    <th class="p-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $antrianBooth[$booth->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="border-t">
                                        <td class="p-3 font-semibold"><?php echo e($row->nomor_antrian); ?></td>
                                        <td class="p-3"><?php echo e($row->pengguna->nama_pengguna ?? '-'); ?></td>
                                        <td class="p-3"><?php echo e($row->paket->nama_paket ?? '-'); ?></td>
                                        <td class="p-3">
                                            <span class="px-3 py-1 rounded-full text-white 
                                                <?php if($row->status == 'menunggu'): ?> bg-yellow-500
                                                <?php elseif($row->status == 'diproses'): ?> bg-blue-500
                                                <?php else: ?> bg-green-500
                                                <?php endif; ?>">
                                                <?php echo e(ucfirst($row->status)); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>

</body>
</html>
<?php /**PATH C:\Users\USER\ukom-antrian-photobooth\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>