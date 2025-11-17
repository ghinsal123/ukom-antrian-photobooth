<?php $__env->startSection('content'); ?>
<h2 class="text-3xl font-bold mb-4 text-gray-800">Daftar Paket</h2>

<div class="overflow-x-auto">
    <table class="table-auto w-full border-collapse rounded-3xl shadow-2xl overflow-hidden">
        <thead class="bg-linear-to-r from-pink-300 to-pink-500 text-white">
            <tr>
                <th class="px-6 py-3">Gambar</th>
                <th class="px-6 py-3">Nama Paket</th>
                <th class="px-6 py-3">Harga</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="bg-white hover:bg-pink-50 transition-all transform hover:scale-105 shadow-md hover:shadow-lg">
                <td class="px-4 py-3 text-center">
                    <?php if($paket->gambar): ?>
                        <img src="<?php echo e(asset('storage/' . $paket->gambar)); ?>" 
                             alt="<?php echo e($paket->nama_paket); ?>" 
                             class="w-24 h-24 object-cover rounded-xl shadow-lg mx-auto transition-transform hover:scale-110">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td class="px-4 py-3 font-semibold text-pink-600"><?php echo e($paket->nama_paket); ?></td>
                <td class="px-4 py-3 font-bold text-pink-500">Rp <?php echo e(number_format($paket->harga, 0, ',', '.')); ?></td>
                <td class="px-4 py-3 text-center">
                    <a href="<?php echo e(route('operator.paket.show', $paket->id)); ?>" 
                       class="bg-pink-500 text-white px-4 py-2 rounded-xl hover:bg-pink-600 shadow-lg transition-all transform hover:scale-105">
                       Detail
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ukom-antrian-photobooth\resources\views/Operator/paket/index.blade.php ENDPATH**/ ?>