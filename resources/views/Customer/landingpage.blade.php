<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FlashFrame Photobooth</title>
    @vite('resources/css/app.css')
    
    <!-- SWIPER (UNTUK SLIDER) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Swiper styling */
        .swiper-slide {
            height: auto !important;
        }
        
        /* Mobile menu animation */
        #mobileMenu {
            transition: all 0.3s ease;
        }
        
        /* Modal styling */
        #boothDetailModal {
            transition: opacity 0.3s ease;
        }
    </style>
</head>

<body class="bg-cover bg-center bg-no-repeat bg-fixed min-h-screen"
      style="background-image: url('/image/bg.jpg');">

    <!-- PINK OVERLAY -->
    <div class="absolute inset-0 bg-pink-50/60"></div>

    <!-- CONTENT WRAPPER -->
    <div class="relative z-10 flex flex-col min-h-screen">

        <!-- NAVBAR -->
        <nav class="bg-white shadow-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo dan Nama Merek -->
                    <div class="flex items-center">
                        <img src="/images/logo.png" alt="FlashFrame Logo" class="h-10 w-10 mr-3">
                        <span class="text-xl font-bold text-pink-600">FlashFrame</span>
                    </div>

                    <!-- Menu Tengah -->
                    <div class="hidden lg:flex items-center space-x-6 mx-auto">
                        <a href="{{ route('customer.landingpage') }}" 
                           class="text-gray-700 hover:text-pink-500 transition-colors duration-300 {{ request()->routeIs('customer.landingpage') ? 'text-pink-500 font-medium' : '' }}">
                            Home
                        </a>
                        <a href="#booth" 
                           class="text-gray-700 hover:text-pink-500 transition-colors duration-300">
                            Booth
                        </a>
                        <a href="#paket" 
                           class="text-gray-700 hover:text-pink-500 transition-colors duration-300">
                            Paket
                        </a>
                        
                        @if ($pengguna)
                            <a href="#antrian" 
                               class="text-gray-700 hover:text-pink-500 transition-colors duration-300">
                                Antrian
                            </a>
                        @endif
                        
                        <a href="#tentang" 
                           class="text-gray-700 hover:text-pink-500 transition-colors duration-300">
                            Tentang
                        </a>
                    </div>

                    <!-- Bagian Login/Register atau Foto Profil -->
                    <div class="flex items-center space-x-4">
                        @if (!$pengguna)
                            <a href="{{ route('customer.login') }}" 
                               class="text-gray-700 hover:text-pink-500 transition-colors duration-300">
                                Masuk
                            </a>
                            <a href="{{ route('customer.daftar') }}"
                               class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors duration-300">
                                Daftar
                            </a>
                        @else
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('customer.antrian') }}" 
                                   class="hidden md:flex items-center px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors duration-300">
                                    Antrian
                                </a>
                                
                                <div class="relative group">
                                    <button class="flex items-center focus:outline-none">
                                        @if($pengguna->foto)
                                            <img src="{{ asset('storage/' . $pengguna->foto) }}" 
                                                alt="Foto Profil {{ $pengguna->nama_pengguna }}"
                                                class="w-10 h-10 rounded-full object-cover border-2 border-pink-300 hover:border-pink-500 transition-colors duration-300"
                                                onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            
                                            <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center border-2 border-pink-300 hover:border-pink-500 transition-colors duration-300 font-bold hidden">
                                                {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                            </div>
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center border-2 border-pink-300 hover:border-pink-500 transition-colors duration-300 font-bold">
                                                {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                            </div>
                                        @endif
                                    </button>
                                    
                                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-pink-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                        <div class="py-2">
                                            <div class="px-4 py-3 border-b border-pink-50 flex items-center space-x-3">
                                                @if($pengguna->foto)
                                                    <img src="{{ asset('storage/' . $pengguna->foto) }}" 
                                                        alt="Foto Profil"
                                                        class="w-10 h-10 rounded-full object-cover border border-pink-300"
                                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    
                                                    <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center font-bold hidden">
                                                        {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                                    </div>
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center font-bold">
                                                        {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $pengguna->nama_pengguna ?? 'User' }}</p>
                                                    <p class="text-xs text-gray-500 truncate">{{ $pengguna->email ?? '' }}</p>
                                                </div>
                                            </div>
                                            
                                            <a href="{{ route('customer.profil.edit') }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-colors">
                                                <i class="fas fa-user-circle mr-2"></i>
                                                Edit Profil
                                            </a>
                                            <a href="{{ route('customer.arsip') }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 transition-colors">
                                                <i class="fas fa-archive mr-2"></i>
                                                Arsip 
                                            </a>
                                            
                                            <div class="border-t border-gray-100 pt-2">
                                                <a href="{{ route('customer.antrian') }}" 
                                                   class="flex items-center px-4 py-2 text-sm text-pink-600 font-medium hover:bg-pink-50 hover:text-pink-700 transition-colors md:hidden">
                                                    Buat Antrian
                                                </a>
                                                
                                                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">
                                                    @csrf
                                                </form>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                   class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                                    Keluar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden text-2xl text-pink-500 ml-4 focus:outline-none" onclick="toggleMenu()">
                        ☰
                    </button>
                </div>
            </div>

            <!-- MOBILE MENU -->
            <div id="mobileMenu" class="hidden lg:hidden bg-white border-t px-4 py-3 shadow-lg">
                <div class="space-y-2">
                    <a href="{{ route('customer.landingpage') }}" class="block py-2 text-gray-700 hover:text-pink-500 transition-colors {{ request()->routeIs('customer.landingpage') ? 'text-pink-500 font-medium' : '' }}">Home</a>
                    <a href="#booth" onclick="closeMobileMenu(); scrollToSection('booth');" class="block py-2 text-gray-700 hover:text-pink-500 transition-colors">Booth</a>
                    <a href="#paket" onclick="closeMobileMenu(); scrollToSection('paket');" class="block py-2 text-gray-700 hover:text-pink-500 transition-colors">Paket</a>
                    
                    @if ($pengguna)
                        <a href="#antrian" onclick="closeMobileMenu(); scrollToSection('antrian');" class="block py-2 text-gray-700 hover:text-pink-500 transition-colors">Antrian</a>
                    @endif
                    
                    <a href="#tentang" onclick="closeMobileMenu(); scrollToSection('tentang');" class="block py-2 text-gray-700 hover:text-pink-500 transition-colors">Tentang</a>

                    @if (!$pengguna)
                        <div class="pt-3 border-t mt-3">
                            <a href="{{ route('customer.login') }}" class="block py-2 text-gray-700 hover:text-pink-500 transition-colors">Masuk</a>
                            <a href="{{ route('customer.daftar') }}" class="block py-2 text-pink-600 font-medium hover:text-pink-700 transition-colors">Daftar</a>
                        </div>
                    @else
                        <div class="pt-3 border-t mt-3">
                            <div class="flex items-center gap-3 mb-3 p-2 bg-pink-50 rounded-lg">
                                @if($pengguna->foto)
                                    <img src="{{ asset('storage/' . $pengguna->foto) }}" 
                                         alt="Foto Profil"
                                         class="w-10 h-10 rounded-full object-cover border border-pink-300"
                                         onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    
                                    <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center font-bold hidden">
                                        {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-pink-100 text-pink-500 flex items-center justify-center font-bold">
                                        {{ substr($pengguna->nama_pengguna ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-sm">{{ $pengguna->nama_pengguna ?? 'User' }}</p>
                                    <p class="text-xs text-gray-500">{{ $pengguna->email ?? '' }}</p>
                                </div>
                            </div>
                            
                            <a href="{{ route('customer.profil.edit') }}" class="flex items-center py-2 text-gray-700 hover:text-pink-500 transition-colors">
                                <i class="fas fa-user-circle mr-2"></i>
                                Profil Saya
                            </a>
                            <a href="{{ route('customer.antrian') }}" class="flex items-center py-2 text-gray-700 hover:text-pink-500 transition-colors">
                                <i class="fas fa-ticket-alt mr-2"></i>
                                Antrian Saya
                            </a>
                            <a href="{{ route('customer.arsip') }}" class="flex items-center py-2 text-gray-700 hover:text-pink-500 transition-colors">
                                <i class="fas fa-archive mr-2"></i>
                                Arsip 
                            </a>
                            
                            <a href="{{ route('customer.antrian') }}" class="flex items-center py-2 text-pink-600 font-medium hover:text-pink-700 transition-colors mt-2 border-t pt-2">
                                Buat Antrian
                            </a>
                            
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               class="flex items-center py-2 text-red-600 hover:text-red-700 transition-colors mt-1">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Keluar
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-grow w-full">

            <!-- MAIN POSTER -->
            <div class="w-full">
                <div class="mx-auto">
                    <img src="/images/PHOTOBOOTH.png"
                         class="w-full h-auto max-h-[700px] object-cover"
                         alt="FlashFrame Photobooth">
                </div>
            </div>

            <!-- SLIDER BOOTH -->
            <div id="booth" class="w-full px-4 sm:px-6 lg:px-8 mt-12">
                <div class="max-w-7xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Booth Tersedia</h3>
                    <p class="text-gray-600 mb-6">Pilih booth favorit Anda untuk pengalaman fotografi terbaik</p>

                    <div class="swiper booth-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($booth as $b)
                                @php
                                    // Hitung antrian aktif hari ini untuk booth ini
                                    $antrianAktifCount = $b->antrian->count();
                                @endphp
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-xl shadow-lg border border-pink-200 h-full flex flex-col overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                        <div class="relative">
                                           <img src="{{ $b->gambar && is_array($b->gambar) ? asset('storage/' . $b->gambar[0]) : '/images/default-booth.jpg' }}" 
                                            alt="{{ $b->nama_booth }}"
                                            class="w-full h-48 object-cover">
                                            <div class="absolute top-3 right-3">
                                                <span class="inline-block px-3 py-1 bg-pink-500 text-white rounded-full text-xs font-medium">
                                                    {{ $antrianAktifCount }} Antrian
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="p-4 flex-1 flex flex-col">
                                            <h4 class="font-bold text-lg text-pink-600 mb-3">{{ $b->nama_booth }}</h4>
                                            
                                            <div class="flex items-center text-gray-600 mb-4">
                                                <i class="fas fa-users text-pink-400 mr-2"></i>
                                                <span class="text-sm font-medium">Maksimal {{ $b->kapasitas ?? '4' }} orang</span>
                                            </div>
                                            
                                            <div class="mt-auto flex gap-2">
                                                <button onclick="showBoothDetail({{ $b->id }})" 
                                                        class="flex-1 px-4 py-2 bg-white border border-pink-300 text-pink-600 rounded-lg text-sm font-medium hover:bg-pink-50 transition-colors duration-300">
                                                    Detail
                                                </button>
                                                
                                                @if ($pengguna)
                                                    <a href="{{ route('customer.antrian') }}?booth_id={{ $b->id }}"
                                                       class="flex-1 text-center px-4 py-2 bg-pink-500 text-white rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors duration-300">
                                                        Order
                                                    </a>
                                                @else
                                                    <a href="{{ route('customer.daftar') }}" 
                                                       class="flex-1 text-center px-4 py-2 bg-pink-500 text-white rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors duration-300">
                                                        Order
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination mt-6"></div>
                    </div>
                </div>
            </div>

            <!-- SLIDER PAKET -->
            <div id="paket" class="w-full px-4 sm:px-6 lg:px-8 mt-12">
                <div class="max-w-7xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Paket Foto</h3>
                    <p class="text-gray-600 mb-6">Berbagai pilihan paket sesuai kebutuhan Anda</p>

                    <div class="swiper paket-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($paket as $p)
                                <div class="swiper-slide">
                                    <div class="bg-white rounded-xl shadow-lg border border-pink-200 h-full flex flex-col overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                        <div class="relative">
                                            <img src="{{ $p->gambar ? asset('storage/' . $p->gambar) : '/images/default-paket.jpg' }}" 
                                                 alt="{{ $p->nama_paket }}"
                                                 class="w-full h-48 object-cover">
                                            @if($p->is_popular ?? false)
                                                <div class="absolute top-3 right-3">
                                                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                                        <i class="fas fa-star mr-1"></i>Popular
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="p-4 flex-1 flex flex-col">
                                            <h4 class="font-bold text-lg text-pink-600 mb-2">{{ $p->nama_paket }}</h4>
                                            
                                            <div class="flex items-center text-gray-600 mb-3">
                                                <i class="far fa-clock text-pink-400 mr-2"></i>
                                                <span class="text-sm">{{ $p->durasi ?? '10' }} menit</span>
                                            </div>
                                            
                                            <p class="text-gray-600 text-sm mb-4 flex-grow">
                                                {{ $p->deskripsi ?? 'Paket foto berkualitas tinggi dengan hasil terbaik untuk moment spesial Anda.' }}
                                            </p>
                                            
                                            <div class="mb-4">
                                                <p class="text-lg font-bold text-pink-700">
                                                    Rp{{ number_format($p->harga, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            
                                            <div class="mt-auto">
                                                @if ($pengguna)
                                                    <a href="{{ route('customer.antrian') }}?paket_id={{ $p->id }}"
                                                       class="w-full block text-center px-4 py-2 bg-pink-500 text-white rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors duration-300">
                                                        Order
                                                    </a>
                                                @else
                                                    <a href="{{ route('customer.daftar') }}" 
                                                       class="w-full block text-center px-4 py-2 bg-pink-500 text-white rounded-lg text-sm font-medium hover:bg-pink-600 transition-colors duration-300">
                                                        Order
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination mt-6"></div>
                    </div>
                </div>
            </div>

            <!-- DAFTAR ANTRIAN UMUM (HARI INI) -->
            <div id="antrian" class="w-full px-4 sm:px-6 lg:px-8 mt-12">
                <div class="max-w-7xl mx-auto">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Antrian Hari Ini</h3>
                            <p class="text-gray-600">Lihat antrian yang sedang berlangsung di setiap booth</p>
                        </div>
                    </div>

                    @php
                        // Filter booth yang memiliki antrian aktif hari ini
                        $boothDenganAntrian = $booth->filter(function($b) {
                            return $b->antrian->count() > 0;
                        });
                    @endphp

                    @if($boothDenganAntrian->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($boothDenganAntrian as $b)
                                @php
                                    // Ambil antrian aktif, urut berdasarkan jam
                                    $antrianAktif = $b->antrian->sortBy('jam');
                                    $antrianDiproses = $antrianAktif->where('status', 'proses')->first();
                                    $antrianMenunggu = $antrianAktif->where('status', 'menunggu');
                                @endphp
                                
                                <div class="bg-white border border-pink-200 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                                    <!-- Header Booth -->
                                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                                        <div>
                                            <h4 class="font-bold text-lg text-pink-600">{{ $b->nama_booth }}</h4>
                                            <div class="flex items-center text-sm text-gray-500 mt-1">
                                                <span>Operasional: 09:00 - 21:30</span>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-sm font-medium">
                                            {{ $antrianAktif->count() }} Antrian
                                        </span>
                                    </div>
                                    
                                    <!-- Sedang Diproses -->
                                    @if($antrianDiproses)
                                        <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="text-sm font-medium text-blue-700">
                                                    SEDANG DIPROSES
                                                </span>
                                                <span class="px-2 py-1 bg-blue-500 text-white rounded text-xs font-bold">
                                                    {{ $antrianDiproses->nomor_antrian }}
                                                </span>
                                            </div>
                                            <div class="space-y-2">
                                                <div class="flex items-center text-sm text-gray-800">
                                                    <span class="font-medium">{{ $antrianDiproses->pengguna->nama_pengguna ?? 'Pelanggan' }}</span>
                                                </div>
                                                <div class="flex items-center text-xs text-gray-700">
                                                    <span>Sesi: {{ substr($antrianDiproses->jam, 0, 5) }}</span>
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $antrianDiproses->paket->nama_paket ?? 'Paket' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Menunggu Giliran -->
                                    @if($antrianMenunggu->count() > 0)
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between mb-3">
                                                <p class="text-sm font-medium text-gray-700">
                                                    MENUNGGU GILIRAN
                                                </p>
                                                <span class="text-xs text-gray-500">Sesi 10 menit</span>
                                            </div>
                                            
                                            @foreach($antrianMenunggu->take(3) as $antrian)
                                                <div class="flex items-center justify-between p-3 bg-pink-50 rounded-lg hover:bg-pink-100 transition-colors duration-300">
                                                    <div class="flex items-center gap-3 flex-1">
                                                        <div class="w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center flex-shrink-0">
                                                            <span class="text-white text-sm font-bold">{{ $antrian->nomor_antrian }}</span>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <div class="font-medium text-sm text-gray-800 truncate">
                                                                {{ $antrian->pengguna->nama_pengguna ?? 'Pelanggan' }}
                                                            </div>
                                                            <div class="flex items-center gap-2 text-xs text-gray-600 mt-1">
                                                                <span>{{ substr($antrian->jam, 0, 5) }}</span>
                                                                <span>•</span>
                                                                <span class="truncate">{{ $antrian->paket->nama_paket ?? 'Paket' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium ml-2">
                                                        Menunggu
                                                    </span>
                                                </div>
                                            @endforeach
                                            
                                            @if($antrianMenunggu->count() > 3)
                                                <div class="text-center text-pink-600 text-sm font-medium pt-2">
                                                    +{{ $antrianMenunggu->count() - 3 }} antrian lainnya...
                                                </div>
                                            @endif
                                        </div>
                                    @elseif(!$antrianDiproses)
                                        <div class="text-center py-8 text-gray-500">
                                            <div class="mx-auto mb-3">
                                                <span class="text-green-500 text-2xl">✓</span>
                                            </div>
                                            <p class="font-medium">Tidak ada antrian menunggu</p>
                                            <p class="text-sm mt-1">Booth siap menerima antrian baru</p>
                                        </div>
                                    @endif
                                    
                                    <!-- Footer -->
                                    <div class="mt-6 pt-4 border-t border-gray-100">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">
                                                Estimasi per sesi:
                                            </span>
                                            <span class="font-medium text-gray-800">{{ $b->estimasi_waktu ?? '10' }} menit</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white border border-pink-200 p-8 rounded-xl shadow-lg text-center">
                            <div class="mx-auto mb-4">
                                <span class="text-pink-500 text-2xl">📷</span>
                            </div>
                            <p class="text-gray-600 text-lg mb-2">Belum ada antrian hari ini</p>
                            <p class="text-gray-500 text-sm mb-6">
                                Jadilah yang pertama membuat antrian untuk sesi foto Anda
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- DAFTAR ANTRIAN SAYA (HANYA ANTRIAN HARI INI) -->
            @if ($pengguna)
                <div class="w-full px-4 sm:px-6 lg:px-8 mt-12">
                    <div class="max-w-7xl mx-auto">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-semibold text-gray-800">Antrian Saya Hari Ini</h3>
                        </div>

                        @php
                            // Filter antrian hari ini yang masih aktif (belum selesai/kadaluarsa)
                            $antrianHariIni = $antrianku->filter(function($item) {
                                return in_array($item->status, ['menunggu', 'proses']);
                            });
                        @endphp

                        @if ($antrianHariIni->count() == 0)
                            <div class="bg-white border border-pink-200 p-8 rounded-xl shadow-lg text-center">
                                <p class="text-gray-600 text-lg mb-2">Belum ada antrian aktif hari ini</p>
                                <p class="text-gray-500 text-sm mb-6">
                                    Silakan buat antrian baru untuk memulai sesi foto Anda
                                </p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($antrianHariIni as $item)
                                    <div class="bg-white border border-pink-200 p-6 rounded-xl shadow hover:shadow-lg transition-shadow duration-300">
                                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                                            <!-- Left Content -->
                                            <div class="flex-1">
                                                <!-- Header with number and status -->
                                                <div class="flex items-center gap-3 mb-4">
                                                    <div class="text-3xl font-bold text-pink-600">
                                                        {{ $item->nomor_antrian }}
                                                    </div>
                                                    @if($item->status == 'menunggu')
                                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">
                                                            Menunggu
                                                        </span>
                                                    @elseif($item->status == 'proses')
                                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                                            Sedang Diproses
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                <!-- Booth and Package Info -->
                                                <div class="mb-4">
                                                    <h4 class="text-lg font-semibold text-gray-800 mb-1">
                                                        {{ $item->booth->nama_booth ?? 'Booth' }}
                                                    </h4>
                                                    <div class="text-sm text-gray-600 mb-3">
                                                        {{ $item->paket->nama_paket ?? 'Paket' }}
                                                    </div>
                                                </div>
                                                
                                                <!-- Details Grid -->
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                                    <div>
                                                        <p class="text-gray-500 text-xs">Tanggal</p>
                                                        <p class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</p>
                                                    </div>
                                                    
                                                    <div>
                                                        <p class="text-gray-500 text-xs">Jam Sesi</p>
                                                        <p class="font-medium">{{ substr($item->jam, 0, 5) }}</p>
                                                    </div>
                                                    
                                                    <div>
                                                        <p class="text-gray-500 text-xs">Durasi</p>
                                                        <p class="font-medium">{{ $item->paket->durasi ?? '10' }} menit</p>
                                                    </div>
                                                    
                                                    <div>
                                                        <p class="text-gray-500 text-xs">Kapasitas</p>
                                                        <p class="font-medium">{{ $item->booth->kapasitas ?? '4' }} orang</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Right Content -->
                                            <div class="md:text-right md:w-48">
                                                <!-- Status Message -->
                                                <div class="mb-4">
                                                    @if($item->status == 'menunggu')
                                                        <div class="text-xs text-gray-500 mb-3">
                                                            <p class="font-medium text-gray-700">Menunggu giliran...</p>
                                                            <p class="mt-1">Bersiaplah untuk sesi Anda</p>
                                                        </div>
                                                    @elseif($item->status == 'proses')
                                                        <div class="text-blue-600 text-sm mb-3">
                                                            <p class="font-medium">Sedang difoto</p>
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            Siapkan pose terbaik Anda!
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <!-- Action Buttons -->
                                                <div class="space-y-2">
                                                    <button onclick="cancelAntrian({{ $item->id }})" 
                                                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-300 text-sm w-full justify-center">
                                                        Batalkan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- TENTANG KAMI -->
            <div id="tentang" class="w-full px-4 sm:px-6 lg:px-8 mt-16 mb-8">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white rounded-xl shadow-lg border border-pink-200 p-8">
                        <div class="text-center mb-8">
                            <h3 class="text-3xl font-bold text-pink-600 mb-4">Tentang FlashFrame Photobooth</h3>
                            <p class="text-gray-600 text-lg max-w-3xl mx-auto">
                                Menghadirkan pengalaman fotografi yang menyenangkan dan mengelola antrian secara efesien.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-camera-retro text-pink-500 text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800 mb-2">Kualitas Terbaik</h4>
                                <p class="text-gray-600 text-sm">
                                 Memiliki paket photo dan booth yang lucu dan menarik.
                                </p>
                            </div>

                            <div class="text-center">
                                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-bolt text-pink-500 text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800 mb-2">Cepat & Efisien</h4>
                                <p class="text-gray-600 text-sm">
                                    Proses pemotretan yang cepat dengan sistem antrian yang terorganisir
                                </p>
                            </div>

                            <div class="text-center">
                                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-heart text-pink-500 text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-lg text-gray-800 mb-2">Ramah Keluarga</h4>
                                <p class="text-gray-600 text-sm">
                                    Cocok untuk semua usia, dari anak-anak hingga orang dewasa
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <!-- FOOTER -->
        <footer class="bg-[#f9f0df] text-gray-800 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Hubungi Kami Section -->
                <div class="mb-8">
                    <h4 class="text-xl font-bold mb-6 text-center text-gray-800">Hubungi Kami</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- WhatsApp -->
                        <div class="text-center">
                            <div class="w-8 h-8 bg-[#f0e6d0] rounded-full flex items-center justify-center mx-auto mb-2 hover:scale-110 transition-transform duration-300">
                                <i class="fab fa-whatsapp text-gray-700 text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-600 mb-1">WhatsApp</p>
                            <p class="text-gray-800 font-medium text-xs hover:text-pink-600 transition-colors duration-300">
                                <a href="https://wa.me/6281234567890" target="_blank">+62 812-3456-7890</a>
                            </p>
                        </div>
                        
                        <!-- Instagram -->
                        <div class="text-center">
                            <div class="w-8 h-8 bg-[#f0e6d0] rounded-full flex items-center justify-center mx-auto mb-2 hover:scale-110 transition-transform duration-300">
                                <i class="fab fa-instagram text-gray-700 text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-600 mb-1">Instagram</p>
                            <p class="text-gray-800 font-medium text-xs hover:text-pink-600 transition-colors duration-300">
                                <a href="https://instagram.com/flashframe.photo" target="_blank">@flashframe.photo</a>
                            </p>
                        </div>
                        
                        <!-- Email -->
                        <div class="text-center">
                            <div class="w-8 h-8 bg-[#f0e6d0] rounded-full flex items-center justify-center mx-auto mb-2 hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-envelope text-gray-700 text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-600 mb-1">Email</p>
                            <p class="text-gray-800 font-medium text-xs hover:text-pink-600 transition-colors duration-300">
                                <a href="mailto:flashframe@gmail.com">flashframe@gmail.com</a>
                            </p>
                        </div>
                        
                        <!-- Lokasi -->
                        <div class="text-center">
                            <div class="w-8 h-8 bg-[#f0e6d0] rounded-full flex items-center justify-center mx-auto mb-2 hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-map-marker-alt text-gray-700 text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-600 mb-1">Lokasi</p>
                            <p class="text-gray-800 font-medium text-xs">Jl. Photobooth No. 123, Bekasi</p>
                        </div>
                    </div>
                </div>
                
                <!-- Copyright Section -->
                <div class="border-t border-[#e0d6c4] pt-6 mt-6 text-center">
                    <p class="text-gray-600 text-sm">
                        © 2024 FlashFrame. Semua hak dilindungi undang-undang.
                    </p>
                    <p class="text-gray-500 text-xs mt-2">
                        Jam Operasional: Setiap Hari 09:00 - 21:30 WIB
                    </p>
                </div>
            </div>
        </footer>

    </div>

    <!-- MODAL DETAIL BOOTH -->
    <div id="boothDetailModal" class="fixed inset-0 bg-black/50 z-[60] hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-4 border-b flex justify-between items-center sticky top-0 bg-white z-10">
                <h3 class="font-semibold text-gray-800 text-lg" id="modalBoothTitle">Detail Booth</h3>
                <button onclick="closeBoothDetailModal()" class="text-2xl text-gray-500 hover:text-gray-700 transition-colors duration-300">&times;</button>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <div class="swiper booth-detail-swiper">
                        <div class="swiper-wrapper" id="modalBoothImages">
                        </div>
                        <div class="swiper-pagination mt-4"></div>
                    </div>
                </div>
                
                <div class="space-y-4" id="modalBoothInfo">
                </div>
                
                <div class="flex gap-2 mt-6">
                    <button onclick="closeBoothDetailModal()" class="flex-1 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300">
                        Tutup
                    </button>
                    @if ($pengguna)
                        <button onclick="orderBoothFromModal()" class="flex-1 py-2.5 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors duration-300">
                            Order Sekarang
                        </button>
                    @else
                        <a href="{{ route('customer.daftar') }}" class="flex-1 py-2.5 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-colors duration-300 text-center">
                            Daftar untuk Order
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SWIPER SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        let boothData = @json($booth->keyBy('id'));
        let currentBoothDetail = null;
        let boothDetailSwiper = null;
        let boothSwiper = null;
        let paketSwiper = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize booth swiper
            boothSwiper = new Swiper('.booth-swiper', {
                slidesPerView: 1.2,
                spaceBetween: 20,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: { slidesPerView: 1.5, spaceBetween: 20 },
                    768: { slidesPerView: 2.2, spaceBetween: 25 },
                    1024: { slidesPerView: 2.8, spaceBetween: 30 },
                    1280: { slidesPerView: 3.2, spaceBetween: 30 }
                }
            });

            // Initialize paket swiper
            paketSwiper = new Swiper('.paket-swiper', {
                slidesPerView: 1.2,
                spaceBetween: 20,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: { slidesPerView: 1.5, spaceBetween: 20 },
                    768: { slidesPerView: 2.2, spaceBetween: 25 },
                    1024: { slidesPerView: 2.8, spaceBetween: 30 },
                    1280: { slidesPerView: 3.2, spaceBetween: 30 }
                }
            });

            // Auto update status antrian setiap 60 detik
            setInterval(() => {
                updateAntrianStatus();
            }, 60000); // 60 detik

            // Update status saat halaman dimuat
            updateAntrianStatus();
        });

        function updateAntrianStatus() {
            fetch('/update-antrian-status', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log('Status antrian diperbarui:', data);
                // Refresh halaman jika ada perubahan status
                if(data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error updating antrian:', error));
        }

        function showBoothDetail(boothId) {
            currentBoothDetail = boothId;
            const booth = boothData[boothId];
            
            if (!booth) {
                alert('Data booth tidak ditemukan');
                return;
            }
            
            document.getElementById('modalBoothTitle').textContent = booth.nama_booth;
            
            const imagesContainer = document.getElementById('modalBoothImages');
            imagesContainer.innerHTML = '';
            
            if (booth.gambar && Array.isArray(booth.gambar) && booth.gambar.length > 0) {
                booth.gambar.forEach((img, index) => {
                    const slide = document.createElement('div');
                    slide.className = 'swiper-slide';
                    slide.innerHTML = `
                        <img src="{{ asset('storage/') }}/${img}" 
                             alt="${booth.nama_booth} ${index + 1}" 
                             class="w-full h-64 md:h-80 object-cover rounded-lg">
                    `;
                    imagesContainer.appendChild(slide);
                });
            } else {
                imagesContainer.innerHTML = `
                    <div class="swiper-slide">
                        <div class="w-full h-64 md:h-80 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-camera text-gray-400 text-3xl"></i>
                        </div>
                    </div>
                `;
            }
            
            if (boothDetailSwiper) {
                boothDetailSwiper.destroy();
            }
            
            boothDetailSwiper = new Swiper('.booth-detail-swiper', {
                slidesPerView: 1,
                spaceBetween: 10,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                loop: booth.gambar && booth.gambar.length > 1,
                autoplay: booth.gambar && booth.gambar.length > 1 ? {
                    delay: 3000,
                } : false,
            });
            
            const infoContainer = document.getElementById('modalBoothInfo');
            const antrianCount = booth.antrian ? booth.antrian.filter(a => a.status === 'menunggu' || a.status === 'proses').length : 0;
            
            infoContainer.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-1 text-sm">Nama Booth</h5>
                        <p class="text-gray-800 text-lg font-medium">${booth.nama_booth}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-1 text-sm">Tipe Booth</h5>
                        <p class="text-gray-800">${booth.tipe_booth || 'Standard Booth'}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-1 text-sm">Kapasitas</h5>
                        <p class="text-gray-800">
                            Maksimal ${booth.kapasitas || '4'} orang
                        </p>
                    </div>
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-1 text-sm">Status</h5>
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                            Tersedia
                        </span>
                    </div>
                </div>
                
                ${booth.deskripsi ? `
                <div class="pt-4">
                    <h5 class="font-semibold text-gray-700 mb-1 text-sm">Deskripsi</h5>
                    <p class="text-gray-800">${booth.deskripsi}</p>
                </div>
                ` : ''}
                
                ${booth.fitur ? `
                <div class="pt-4">
                    <h5 class="font-semibold text-gray-700 mb-1 text-sm">Fitur</h5>
                    <p class="text-gray-800">${booth.fitur}</p>
                </div>
                ` : ''}
                
                <div class="pt-4 border-t">
                    <h5 class="font-semibold text-gray-700 mb-2 text-sm">Statistik Antrian Hari Ini</h5>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-pink-50 p-3 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                                    <span class="text-pink-600 text-sm font-bold">${antrianCount}</span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Total Antrian</p>
                                    <p class="text-xs text-gray-500">Hari ini</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-blue-50 p-3 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Durasi Sesi</p>
                                    <p class="text-xs text-gray-500">${booth.estimasi_waktu || '10'} menit</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('boothDetailModal').classList.remove('hidden');
            document.getElementById('boothDetailModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeBoothDetailModal() {
            document.getElementById('boothDetailModal').classList.add('hidden');
            document.getElementById('boothDetailModal').classList.remove('flex');
            document.body.style.overflow = 'auto';
            
            if (boothDetailSwiper) {
                boothDetailSwiper.destroy();
                boothDetailSwiper = null;
            }
        }

        function orderBoothFromModal() {
            if (currentBoothDetail) {
                window.location.href = "{{ route('customer.antrian') }}?booth_id=" + currentBoothDetail;
            }
        }

        function cancelAntrian(antrianId) {
            if (confirm('Apakah Anda yakin ingin membatalkan antrian ini?')) {
                fetch(`/antrian/${antrianId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ _method: 'PUT' })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Antrian berhasil dibatalkan');
                        location.reload();
                    } else {
                        alert('Gagal membatalkan antrian: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat membatalkan antrian');
                });
            }
        }

        function toggleMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }
        
        function closeMobileMenu() {
            document.getElementById('mobileMenu').classList.add('hidden');
        }
        
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                setTimeout(() => {
                    section.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 100);
                closeMobileMenu();
            }
        }

        // Close modal when clicking outside
        document.getElementById('boothDetailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBoothDetailModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeBoothDetailModal();
            }
        });
    </script>

</body>
</html>