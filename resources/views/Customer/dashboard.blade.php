<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-pink-50">
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

        <p class="text-lg text-gray-700 font-semibold mt-1 mb-6">
            Halo {{ $nama }}, selamat datang di dunia photogenic kamu! 
        </p>

        
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Antrian Per Booth</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

            
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Vintage</h4>
                <div class="space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-800">VT001 — Sarah</span>
                        <span class="text-gray-500 text-sm">Menunggu</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-800">VT002 — Andi</span>
                        <span class="text-gray-500 text-sm">Menunggu</span>
                    </div>
                </div>
            </div>

        
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Classic</h4>
                <div class="space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-800">CL001 — Bella</span>
                        <span class="text-gray-500 text-sm">Sedang Foto</span>
                    </div>

                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-800">CL002 — Roni</span>
                        <span class="text-gray-500 text-sm">Menunggu</span>
                    </div>
                </div>
            </div>

         
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Minimal</h4>
                <div class="space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-800">MN001 — Kevin</span>
                        <span class="text-gray-500 text-sm">Menunggu</span>
                    </div>
                    <p class="text-gray-400 text-sm italic mt-2">Belum ada antrian lain</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Modern</h4>
                <div class="space-y-3">
                    <p class="text-gray-400 text-sm italic mt-2">Belum ada antrian</p>
                </div>
            </div>

       
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Neutral</h4>
                <div class="space-y-3">
                    <p class="text-gray-400 text-sm italic mt-2">Belum ada antrian</p>
                </div>
            </div>

        
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h4 class="text-xl font-bold text-pink-500 mb-4">Booth Bright</h4>
                <div class="space-y-3">
                    <p class="text-gray-400 text-sm italic mt-2">Belum ada antrian</p>
                </div>
            </div>

        </div>

     
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Aktivitas Kamu</h3>

        <div class="bg-white p-6 rounded-xl shadow-sm space-y-6">

            @forelse(($antrianku ?? []) as $item)
                <div class="border-b pb-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-800">
                                {{ $item->nomor_antrian }} — {{ $nama }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Booth: {{ $item->booth_id }} • Status: {{ $item->status }}
                            </p>
                        </div>

                        <div class="flex gap-4">
                            <a href="{{ route('customer.activity.detail', $item->id) }}" class="text-blue-500">Detail</a>
                            <a href="{{ route('customer.activity.edit', $item->id) }}" class="text-yellow-500">Edit</a>
                            <a href="/customer/activity/{{ $item->id }}/delete" class="text-red-500">Delete</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 italic">Belum ada aktivitas antrian.</p>
            @endforelse

        </div>

    </div>

</body>
</html>
