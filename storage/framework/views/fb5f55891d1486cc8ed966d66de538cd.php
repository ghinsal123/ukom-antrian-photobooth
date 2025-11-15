<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> - FlashFrame Admin</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/Admin/style.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <div class="logo">
            <img src="<?php echo e(asset('images/logocamera.png')); ?>" alt="Logo">
            <h2>FlashFrame</h2>
        </div>
        <ul class="menu">
            <li><a href="/admin/dashboard" class="<?php echo e(request()->is('admin/dashboard') ? 'active' : ''); ?>"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="/admin/booths" class="<?php echo e(request()->is('admin/booths') ? 'active' : ''); ?>"><i class="fas fa-camera"></i> Booth</a></li>
            <li><a href="/admin/packages" class="<?php echo e(request()->is('admin/packages') ? 'active' : ''); ?>"><i class="fas fa-box"></i> Paket</a></li>
            <li><a href="/admin/users" class="<?php echo e(request()->is('admin/users') ? 'active' : ''); ?>"><i class="fas fa-user"></i> Akun</a></li>
            <li><a href="/admin/reports" class="<?php echo e(request()->is('admin/reports') ? 'active' : ''); ?>"><i class="fas fa-file-alt"></i> Laporan</a></li>
        </ul>
    </aside>

    <main class="content">
        <header class="topbar">
            <h1><?php echo $__env->yieldContent('title'); ?></h1>
            <div class="profile">
                <img src="<?php echo e(asset('images/avatar.png')); ?>" alt="Avatar">
                <div>
                    <p><strong>Admin</strong></p>
                    <p class="email">flashframe@studio.com</p>
                </div>
            </div>
        </header>

        <section class="page-content">
            <?php echo $__env->yieldContent('content'); ?>
        </section>

        <footer class="footer">
            © FlashFrame • 2025
        </footer>
    </main>
</div>
</body>
</html>
<?php /**PATH D:\belajarLaravel\ukomAntrianPhotobooth\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>