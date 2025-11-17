<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Daftar Antrian</h2>
        <a href="<?php echo e(route('operator.antrian.create')); ?>" 
           class="bg-yellow-500 text-white font-semibold px-5 py-2 rounded-xl shadow-lg hover:bg-yellow-600 transition-all">
           + Tambah Antrian
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse rounded-3xl shadow-2xl overflow-hidden">
            <thead class="bg-linear-to-r from-pink-300 to-pink-500 text-white">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Booth</th>
                    <th class="px-6 py-3">Paket</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $antrian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="bg-white hover:bg-pink-50 transition-all transform hover:scale-105 shadow-md hover:shadow-lg">
                    <td class="px-4 py-3 font-medium text-pink-600"><?php echo e($item->pengguna->nama ?? '-'); ?></td>
                    <td class="px-4 py-3 text-pink-500 font-semibold"><?php echo e($item->booth->nama_booth); ?></td>
                    <td class="px-4 py-3 text-pink-500 font-semibold"><?php echo e($item->paket->nama_paket); ?></td>
                    <td class="px-4 py-3 text-pink-500 font-semibold"><?php echo e($item->tanggal); ?></td>
                    <td class="px-4 py-3 text-center">
                        <?php if($item->status === 'selesai'): ?>
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-sm font-semibold">Selesai</span>
                        <?php elseif($item->status === 'dalam proses'): ?>
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full text-sm font-semibold">Proses</span>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-sm font-semibold">Batal</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 text-center flex gap-2 justify-center">
                        <a href="<?php echo e(route('operatorantrian.show', $item->id)); ?>" 
                           class="bg-blue-500 text-white px-3 py-1 rounded-xl hover:bg-blue-600 shadow-md transition-all">
                           Detail
                        </a>
                        <a href="<?php echo e(route('operator.antrian.edit', $item->id)); ?>" 
                           class="bg-yellow-400 text-white px-3 py-1 rounded-xl hover:bg-yellow-500 shadow-md transition-all">
                           Edit
                        </a>
                        <form action="<?php echo e(route('operator.antrian.delete', $item->id)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                class="bg-red-500 text-white px-3 py-1 rounded-xl hover:bg-red-600 shadow-md transition-all">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ukom-antrian-photobooth\resources\views/Operator/antrian/index.blade.php ENDPATH**/ ?>