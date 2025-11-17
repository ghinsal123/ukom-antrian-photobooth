<?php $__env->startSection('content'); ?>
<div class="container">

    <h2 class="text-2xl font-bold mb-4">Daftar Jadwal Antrian</h2>

    <table class="table-auto w-full border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-3 py-2 border">#</th>
                <th class="px-3 py-2 border">Tanggal</th>
                <th class="px-3 py-2 border">Nomor Antrian</th>
                <th class="px-3 py-2 border">Status</th>
                <th class="px-3 py-2 border">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $__currentLoopData = $jadwals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="px-3 py-2 border"><?php echo e($loop->iteration); ?></td>
                <td class="px-3 py-2 border"><?php echo e($j->tanggal); ?></td>
                <td class="px-3 py-2 border"><?php echo e($j->nomor_antrian); ?></td>
                <td class="px-3 py-2 border"><?php echo e(ucfirst($j->status)); ?></td>
                <td class="px-3 py-2 border">
                    <a href="<?php echo e(route('jadwal.show', $j->id)); ?>" class="text-blue-600 font-semibold">
                        Lihat Detail
                    </a>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>

    </table>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Operator.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\ukom-antrian-photobooth\resources\views/Operator/jadwal/index.blade.php ENDPATH**/ ?>