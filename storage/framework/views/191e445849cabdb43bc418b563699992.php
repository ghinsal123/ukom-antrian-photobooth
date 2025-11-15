<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Panel</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
</head>
<body class="bg-gray-100">

    <nav class="bg-pink-500 text-white p-4">
        <h1 class="font-bold text-xl">Operator Panel</h1>
    </nav>

    <div class="p-6">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

</body>
</html>
<?php /**PATH C:\ukom-antrian-photobooth\resources\views/Operator/layout.blade.php ENDPATH**/ ?>