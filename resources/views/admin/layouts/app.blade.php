<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - FlashFrame Admin</title>
    <link rel="stylesheet" href="{{ asset('css/Admin/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logocamera.png') }}" alt="Logo">
            <h2>FlashFrame</h2>
        </div>
        <ul class="menu">
            <li><a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="/admin/booths" class="{{ request()->is('admin/booths') ? 'active' : '' }}"><i class="fas fa-camera"></i> Booth</a></li>
            <li><a href="/admin/packages" class="{{ request()->is('admin/packages') ? 'active' : '' }}"><i class="fas fa-box"></i> Paket</a></li>
            <li><a href="/admin/users" class="{{ request()->is('admin/users') ? 'active' : '' }}"><i class="fas fa-user"></i> Akun</a></li>
            <li><a href="/admin/reports" class="{{ request()->is('admin/reports') ? 'active' : '' }}"><i class="fas fa-file-alt"></i> Laporan</a></li>
        </ul>
    </aside>

    <main class="content">
        <header class="topbar">
            <h1>@yield('title')</h1>
            <div class="profile">
                <img src="{{ asset('images/avatar.png') }}" alt="Avatar">
                <div>
                    <p><strong>Admin</strong></p>
                    <p class="email">flashframe@studio.com</p>
                </div>
            </div>
        </header>

        <section class="page-content">
            @yield('content')
        </section>

        <footer class="footer">
            © FlashFrame • 2025
        </footer>
    </main>
</div>
</body>
</html>
