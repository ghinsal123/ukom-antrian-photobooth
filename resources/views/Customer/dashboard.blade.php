<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            
            <h1 class="text-2xl font-bold text-pink-400">PhotoBooth FlashFrame</h1>

            <div class="flex gap-6 items-center">
                <a href="{{ route('customer.dashboard') }}" class="text-pink-400 font-semibold">Dashboard</a>
                <a href="{{ route('customer.antrian') }}" class="text-gray-600 hover:text-pink-400">+ Antrian</a>
                <a href="{{ route('customer.logout') }}" class="text-gray-600 hover:text-pink-400">Logout</a>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 py-8">

        <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>

        <!-- Nama Customer -->
        <p class="text-lg text-gray-700 font-semibold mt-1 mb-6">
           Halo, {{ $nama }}
        </p>

        <!-- SUMMARY BOXES -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <p class="text-gray-500">Total Antrian Semua Studio</p>
                <h3 class="text-3xl font-bold text-pink-500 mt-2">5 Orang</h3>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm">
                <p class="text-gray-500">Studio Berjalan</p>
                <h3 class="text-3xl font-bold text-pink-500 mt-2">3 Ruangan</h3>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm">
                <p class="text-gray-500">Reservasi Kamu</p>
                <h3 class="text-3xl font-bold text-pink-500 mt-2">3 Reservasi</h3>
            </div>
        </div>

        <!-- ANTRIAN PER STUDIO -->
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Antrian Per Studio</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

            <!-- Studio A -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-xl font-bold text-pink-500 mb-4">Studio A</h4>
                <div class="space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-800">A001 — Sarah</span>
                        <span class="text-gray-500 text-sm">Menunggu</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-800">A002 — Andi</span>
                        <span class="text-gray-500 text-sm">Menunggu</span>
                    </div>
                </div>
            </div>

            <!-- Studio B -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-xl font-bold text-pink-500 mb-4">Studio B</h4>
                <div class="space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-800">B001 — Bella</span>
                        <span class="text-gray-500 text-sm">Sedang Foto</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-800">B002 — Roni</span>
                        <span class="text-gray-500 text-sm">Menunggu</span>
                    </div>
                </div>
            </div>

            <!-- Studio C -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-xl font-bold text-pink-500 mb-4">Studio C</h4>
                <div class="space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-800">C001 — Kevin</span>
                        <span class="text-gray-500 text-sm">Menunggu</span>
                    </div>
                    <p class="text-gray-400 text-sm italic mt-2">Belum ada antrian lain</p>
                </div>
            </div>

        </div>

        <!-- AKTIVITAS KAMU -->
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Aktivitas Kamu</h3>

        <div class="bg-white p-6 rounded-xl shadow-sm space-y-6">

            <!-- ITEM 1 -->
            <div class="border-b pb-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-800">A003 — Stephanie</p>
                        <p class="text-sm text-gray-500">Studio A • Menunggu</p>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('customer.activity.detail', 3) }}" class="text-blue-500 font-semibold text-sm hover:underline">Detail</a>
                        <a href="{{ route('customer.activity.edit', 3) }}" class="text-yellow-500 font-semibold text-sm hover:underline">Edit</a>
                        <a href="/customer/activity/3/delete" class="text-red-500 font-semibold text-sm hover:underline">Delete</a>
                    </div>
                </div>
            </div>

            <!-- ITEM 2 -->
            <div>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-gray-800">C002 — Dwi</p>
                        <p class="text-sm text-gray-500">Studio C • Menunggu</p>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('customer.activity.detail', 2) }}" class="text-blue-500 font-semibold text-sm hover:underline">Detail</a>
                        <a href="{{ route('customer.activity.edit', 2) }}" class="text-yellow-500 font-semibold text-sm hover:underline">Edit</a>
                        <a href="/customer/activity/2/delete" class="text-red-500 font-semibold text-sm hover:underline">Delete</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
