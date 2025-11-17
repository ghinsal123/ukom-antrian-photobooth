<?php $__env->startSection('content'); ?>
<h2 class="text-xl font-bold mb-4">Daftar Antrian</h2>

<a href="<?php echo e(route('operator.antrian.create')); ?>" class="bg-pink-500 text-white px-4 py-2 rounded">Tambah Antrian</a>

<table class="min-w-full mt-4 bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-3">Nama</th>
            <th class="p-3">Booth</th>
            <th class="p-3">Paket</th>
            <th class="p-3">Tanggal</th>
            <th class="p-3">Status</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php $__currentLoopData = $antrian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="border-b">
            <td class="p-3"><?php echo e($item->pengguna->nama ?? '-'); ?></td>
            <td class="p-3"><?php echo e($item->booth->nama_booth); ?></td>
            <td class="p-3"><?php echo e($item->paket->nama_paket); ?></td>
            <td class="p-3"><?php echo e($item->tanggal); ?></td>
            <td class="p-3 capitalize"><?php echo e($item->status); ?></td>
            <td class="p-3 flex gap-2">

                <a href="<?php echo e(route('operatorantrian.show', $item->id)); ?>" class="text-blue-600">Detail</a>
                <a href="<?php echo e(route('operator.antrian.edit', $item->id)); ?>" class="text-yellow-600">Edit</a>

                <form action="<?php echo e(route('operator.antrian.delete', $item->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="text-red-600">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ukom-antrian-photobooth\resources\views/Operator/antrian/index.blade.php ENDPATH**/ ?>