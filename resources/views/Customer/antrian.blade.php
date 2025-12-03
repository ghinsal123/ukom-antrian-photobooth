<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Antrian - PhotoBooth FlashFrame</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-pink-50 min-h-screen">

    {{-- POPUP SUCCESS --}}
    @if(session('success'))
        <div id="popupSuccess" class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
            <div class="popupContent bg-white p-8 rounded-2xl shadow-xl w-[350px] text-center scale-75 opacity-0 animate-zoomIn">
                <div class="mx-auto w-20 h-20 flex items-center justify-center rounded-full border border-green-400 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p class="text-lg font-semibold text-gray-700 mb-4">{{ session('success') }}</p>
                <button onclick="document.getElementById('popupSuccess').remove()" class="px-5 py-2 bg-pink-500 text-white rounded-lg shadow hover:bg-pink-600">OK</button>
            </div>
        </div>
        <style>
            @keyframes zoomIn {0%{transform:scale(0.6);opacity:0}70%{transform:scale(1.05);opacity:1}100%{transform:scale(1.3);opacity:1}}
            .animate-zoomIn {animation: zoomIn 0.25s ease-out forwards;}
        </style>
    @endif

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-lg sm:text-xl font-bold text-pink-500">PhotoBooth FlashFrame</h1>
            <div class="hidden md:flex gap-6 items-center text-sm">
                <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-pink-500">Dashboard</a>
                <a href="{{ route('customer.antrian') }}" class="text-pink-500 font-semibold">+ Antrian</a>
                <a href="{{ route('customer.arsip') }}" class="text-gray-600 hover:text-pink-500">Arsip</a>
                <a href="#" onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();" class="text-gray-600 hover:text-pink-500">Logout</a>
                <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
            <button class="md:hidden text-2xl text-pink-500" onclick="toggleMenu()">☰</button>
        </div>
        <div id="mobileMenu" class="hidden md:hidden px-4 pb-4 space-y-2">
            <a href="{{ route('customer.dashboard') }}" class="block text-gray-700 hover:text-pink-500">Dashboard</a>
            <a href="{{ route('customer.antrian') }}" class="block text-pink-500 font-semibold">+ Antrian</a>
            <a href="{{ route('customer.arsip') }}" class="block text-gray-700 hover:text-pink-500">Arsip</a>
            <a href="#" onclick="event.preventDefault(); if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit();" class="block text-gray-700 hover:text-pink-500">Logout</a>
        </div>
    </nav>

    <!-- FORM ANTRIAN -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6">Form Antrian PhotoBooth</h2>

        <form action="{{ route('customer.antrian.store') }}" method="POST" id="antrianForm">
            @csrf
            
            <!-- INFORMASI PENGUNJUNG -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pengunjung</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                        <input type="text" value="{{ $pengguna->nama_pengguna }}" readonly 
                               class="w-full p-3 border rounded-lg bg-gray-50 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                        <input type="text" value="{{ $pengguna->no_telp }}" readonly 
                               class="w-full p-3 border rounded-lg bg-gray-50 text-gray-700">
                    </div>
                </div>
            </div>

            <!-- PILIH PAKET -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Paket Foto</h3>
                <p class="text-gray-600 mb-4">Setiap paket sudah termasuk jumlah cetakan foto tertentu</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    @foreach($paket as $p)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-pink-300 transition-all duration-200 cursor-pointer paket-card"
                         data-id="{{ $p->id }}"
                         data-name="{{ $p->nama_paket }}"
                         data-harga="{{ $p->harga }}"
                         data-strip="{{ $p->jumlah_strip }}"
                         data-deskripsi="{{ $p->deskripsi }}">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $p->nama_paket }}</h4>
                                <p class="text-sm text-pink-500 font-medium">{{ $p->jumlah_strip }} cetakan</p>
                            </div>
                            <div class="w-6 h-6 rounded-full border border-gray-300 flex items-center justify-center">
                                <div class="w-3 h-3 rounded-full bg-pink-500 hidden"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            @if($p->gambar)
                                <img src="{{ asset('storage/' . $p->gambar) }}" alt="{{ $p->nama_paket }}" 
                                     class="w-full h-32 object-cover rounded-lg">
                            @else
                                <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="mb-2">
                            <p class="text-lg font-bold text-pink-500">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-sm text-gray-600 line-clamp-2">{{ $p->deskripsi }}</p>
                    </div>
                    @endforeach
                </div>
                
                <input type="hidden" name="paket_id" id="selectedPaketId" value="">
            </div>

            <!-- TAMBAH CETAKAN OPSIONAL -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6 hidden" id="tambahStripSection">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Cetakan Foto (Opsional)</h3>
                
                <div class="mb-4">
                    <p class="text-gray-600 mb-2">Paket terpilih sudah termasuk <span id="stripTermasuk" class="font-semibold">0</span> cetakan</p>
                    <p class="text-sm text-gray-500 mb-4">Ingin menambah cetakan? Harga tambahan: <span class="font-semibold text-pink-500">Rp 10.000</span>/cetakan</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="flex items-center">
                        <button type="button" onclick="decreaseStrip()" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-700 text-xl">-</button>
                        <input type="number" name="tambah_strip" id="tambahStripInput" min="0" value="0" 
                               class="w-20 h-10 text-center border-t border-b border-gray-300 mx-2" readonly>
                        <button type="button" onclick="increaseStrip()" class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-700 text-xl">+</button>
                    </div>
                    <div class="ml-auto">
                        <p class="text-gray-600">Biaya tambahan: <span id="biayaTambahan" class="font-semibold">Rp 0</span></p>
                    </div>
                </div>
            </div>

            <!-- PILIH BOOTH -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Booth Foto</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    @foreach($booth as $b)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-pink-300 transition-all duration-200 cursor-pointer booth-card"
                         data-id="{{ $b->id }}"
                         data-name="{{ $b->nama_booth }}">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $b->nama_booth }}</h4>
                                <p class="text-sm text-gray-500">{{ $b->tipe_booth }}</p>
                            </div>
                            <div class="w-6 h-6 rounded-full border border-gray-300 flex items-center justify-center">
                                <div class="w-3 h-3 rounded-full bg-pink-500 hidden"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            @if($b->gambar && is_array($b->gambar) && count($b->gambar) > 0)
                                <img src="{{ asset('storage/' . $b->gambar[0]) }}" alt="{{ $b->nama_booth }}" 
                                     class="w-full h-32 object-cover rounded-lg">
                            @else
                                <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <button type="button" class="text-xs px-3 py-1.5 border border-gray-300 rounded hover:bg-gray-50 text-gray-700 booth-detail flex-1" 
                                    data-id="{{ $b->id }}">Lihat Detail</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <input type="hidden" name="booth_id" id="selectedBoothId" value="">
            </div>

            <!-- TANGGAL & WAKTU -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Pilih Waktu Reservasi</h3>
                
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Tanggal Reservasi</label>
                    <input type="date" name="tanggal_reservasi" id="tanggalInput" value="{{ date('Y-m-d') }}" 
                           readonly class="w-full md:w-1/3 p-3 border rounded-lg bg-gray-50 text-gray-700">
                    <p class="text-sm text-gray-500 mt-2">* Reservasi hanya untuk hari ini</p>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Pilih Jam (Sesi 10 menit)</label>
                    <p class="text-sm text-gray-500 mb-3">Jam operasional: 09:00 - 21:30</p>
                    
                    <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-2 max-h-96 overflow-y-auto p-2">
                        @php
                            // Generate time slots from 09:00 to 21:30 with 10-minute intervals
                            $timeSlots = [];
                            $start = strtotime('09:00');
                            $end = strtotime('21:30');
                            
                            while ($start <= $end) {
                                $timeSlots[] = date('H:i', $start);
                                $start = strtotime('+10 minutes', $start);
                            }
                        @endphp
                        
                        @foreach($timeSlots as $time)
                        <button type="button" class="time-slot p-3 border border-gray-300 rounded-lg text-sm hover:border-pink-300 bg-white"
                                data-time="{{ $time }}"
                                onclick="selectTimeSlot(this, '{{ $time }}')">
                            {{ $time }}
                        </button>
                        @endforeach
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-3">
                        <span class="inline-block w-3 h-3 bg-pink-500 rounded-full mr-1"></span> Terpilih 
                        <span class="inline-block w-3 h-3 bg-white border border-gray-300 rounded-full mx-2"></span> Tersedia
                    </p>
                </div>
                
                <input type="hidden" name="waktu_reservasi" id="selectedTime" value="">
            </div>

            <!-- RINGKASAN PEMESANAN -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Pemesanan</h3>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Paket Foto</span>
                        <span class="font-medium" id="ringkasanPaket">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah Cetakan</span>
                        <span class="font-medium" id="ringkasanStrip">- cetakan</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Booth</span>
                        <span class="font-medium" id="ringkasanBooth">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal & Waktu</span>
                        <span class="font-medium" id="ringkasanWaktu">-</span>
                    </div>
                </div>
                
                <div class="border-t pt-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Harga Paket</span>
                        <span class="font-medium" id="hargaPaket">Rp 0</span>
                    </div>
                    <div class="flex justify-between mb-2" id="tambahStripRow" style="display: none;">
                        <span class="text-gray-600">Tambah Cetakan</span>
                        <span class="font-medium" id="hargaTambahan">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-3 border-t">
                        <span>Total Pembayaran</span>
                        <span class="text-pink-500" id="totalHarga">Rp 0</span>
                    </div>
                </div>
            </div>

            <!-- TOMBOL SUBMIT -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-gray-600 text-sm">Pastikan semua data sudah benar sebelum melanjutkan</p>
                    <button type="button" id="submitBtn" 
                            class="px-8 py-3 bg-pink-500 text-white rounded-lg font-semibold hover:bg-pink-600 transition disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled
                            onclick="showTiketModal()">
                        Buat Antrian
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- MODAL DETAIL BOOTH -->
    <div id="detailModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-4 border-b flex justify-between items-center sticky top-0 bg-white">
                <h3 class="font-semibold text-gray-800 text-lg" id="modalTitle">Detail Booth</h3>
                <button onclick="closeDetailModal()" class="text-2xl text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <div class="p-6">
                <!-- Booth Images -->
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">Galeri Booth</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3" id="modalImages">
                        <!-- Images will be loaded here -->
                    </div>
                </div>
                
                <!-- Booth Information -->
                <div id="modalInfo" class="space-y-3">
                    <!-- Information will be loaded here -->
                </div>
                
                <div class="flex gap-2 mt-6">
                    <button onclick="closeDetailModal()" class="flex-1 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50">Tutup</button>
                    <button onclick="selectBoothFromModal()" class="flex-1 py-2.5 bg-pink-500 text-white rounded-lg hover:bg-pink-600">Pilih Booth Ini</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TIKET -->
    <div id="tiketModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full">
            <div class="p-6">
                <!-- Tiket Header -->
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Tiket Antrian</h3>
                    <p class="text-gray-600 mb-1" id="ticketDateTime"></p>
                </div>
                
                <!-- Tiket Details -->
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Customer:</span>
                        <span class="font-medium" id="ticketCustomer">{{ $pengguna->nama_pengguna }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Telepon:</span>
                        <span class="font-medium" id="ticketPhone">{{ $pengguna->no_telp }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Booth:</span>
                        <span class="font-medium" id="ticketBooth">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Paket:</span>
                        <span class="font-medium" id="ticketPaket">-</span>
                    </div>
                </div>
                
                <!-- Status & Nomor Antrian -->
                <div class="text-center mb-6">
                    <div class="inline-block px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-semibold mb-2">
                        Menunggu
                    </div>
                    <h4 class="text-4xl font-bold text-gray-800 mb-4" id="ticketNumber">001</h4>
                    <p class="text-sm text-gray-600 mb-4">Silakan cetak barcode ini.</p>
                    
                    <!-- Barcode Placeholder -->
                    <div class="h-20 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                        <div class="text-center">
                            <div class="text-3xl">📋</div>
                            <div class="text-xs mt-1 text-gray-500">Barcode Antrian</div>
                        </div>
                    </div>
                </div>
                
                <!-- Tiket Actions -->
                <div class="space-y-3">
                    <button type="button" class="w-full py-2.5 border border-gray-300 rounded-lg font-medium hover:bg-gray-50">
                        Lihat Detail Antrian
                    </button>
                    <button type="button" onclick="closeTiketModal()" class="w-full py-2.5 border border-gray-300 rounded-lg font-medium hover:bg-gray-50">
                        Kembali ke Daftar Antrian
                    </button>
                    <button type="button" class="w-full py-2.5 bg-blue-500 text-white rounded-lg font-medium hover:bg-blue-600">
                        Cetak PDF
                    </button>
                    <button type="button" class="w-full py-2.5 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600">
                        Batalkan Antrian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data state
        let selectedPaket = null;
        let selectedBooth = null;
        let selectedTime = null;
        let tambahStrip = 0;
        const hargaPerStrip = 10000; // 10k per strip
        let currentModalBoothId = null;
        let boothData = {!! json_encode($booth->keyBy('id')) !!};

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Set date to today and readonly
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggalInput').value = today;
            
            // Update ringkasan waktu
            updateRingkasanWaktu();
            
            // Initialize time slots - SEMUA TERSEDIA, tidak ada disabled
            initializeTimeSlots();
        });

        // Paket Selection
        document.querySelectorAll('.paket-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove selection from all cards
                document.querySelectorAll('.paket-card').forEach(c => {
                    c.classList.remove('border-pink-500', 'bg-pink-50');
                    c.querySelector('.w-3.h-3').classList.add('hidden');
                });
                
                // Add selection to clicked card
                this.classList.add('border-pink-500', 'bg-pink-50');
                this.querySelector('.w-3.h-3').classList.remove('hidden');
                
                selectedPaket = {
                    id: this.dataset.id,
                    name: this.dataset.name,
                    harga: parseInt(this.dataset.harga),
                    strip: parseInt(this.dataset.strip),
                    deskripsi: this.dataset.deskripsi
                };
                
                // Update hidden input
                document.getElementById('selectedPaketId').value = selectedPaket.id;
                
                // Show tambah strip section
                document.getElementById('tambahStripSection').classList.remove('hidden');
                document.getElementById('stripTermasuk').textContent = selectedPaket.strip;
                
                // Reset tambah strip
                tambahStrip = 0;
                document.getElementById('tambahStripInput').value = 0;
                
                // Update ringkasan
                updateRingkasan();
                validateForm();
            });
        });

        // Booth Selection
        document.querySelectorAll('.booth-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (!e.target.classList.contains('booth-detail')) {
                    selectBooth(this);
                }
            });
        });

        function selectBooth(cardElement) {
            // Remove selection from all cards
            document.querySelectorAll('.booth-card').forEach(c => {
                c.classList.remove('border-pink-500', 'bg-pink-50');
                c.querySelector('.w-3.h-3').classList.add('hidden');
            });
            
            // Add selection to clicked card
            cardElement.classList.add('border-pink-500', 'bg-pink-50');
            cardElement.querySelector('.w-3.h-3').classList.remove('hidden');
            
            const boothId = cardElement.dataset.id;
            selectedBooth = {
                id: boothId,
                name: cardElement.dataset.name
            };
            
            // Update hidden input
            document.getElementById('selectedBoothId').value = selectedBooth.id;
            
            // Update ringkasan
            updateRingkasan();
            validateForm();
        }

        // Booth Detail
        document.querySelectorAll('.booth-detail').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const boothId = this.dataset.id;
                showBoothDetail(boothId);
            });
        });

        function showBoothDetail(boothId) {
            currentModalBoothId = boothId;
            const booth = boothData[boothId];
            
            if (!booth) return;
            
            // Set modal title
            document.getElementById('modalTitle').textContent = `Detail ${booth.nama_booth}`;
            
            // Clear previous images
            const imagesContainer = document.getElementById('modalImages');
            imagesContainer.innerHTML = '';
            
            // Add images
            if (booth.gambar && Array.isArray(booth.gambar) && booth.gambar.length > 0) {
                booth.gambar.forEach((img, index) => {
                    const imgCol = document.createElement('div');
                    imgCol.className = 'col-span-1';
                    imgCol.innerHTML = `
                        <img src="{{ asset('storage/') }}/${img}" 
                             alt="${booth.nama_booth} ${index + 1}" 
                             class="w-full h-48 object-cover rounded-lg hover:scale-105 transition-transform duration-200 cursor-pointer">
                    `;
                    imagesContainer.appendChild(imgCol);
                });
            } else {
                imagesContainer.innerHTML = `
                    <div class="col-span-3">
                        <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400">Tidak ada gambar tersedia</span>
                        </div>
                    </div>
                `;
            }
            
            // Set booth information
            const infoContainer = document.getElementById('modalInfo');
            infoContainer.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-1">Nama Booth</h5>
                        <p class="text-gray-800">${booth.nama_booth}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-1">Tipe Booth</h5>
                        <p class="text-gray-800">${booth.tipe_booth || '-'}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-1">Kapasitas</h5>
                        <p class="text-gray-800">${booth.kapasitas || '-'} orang</p>
                    </div>
                    <div>
                        <h5 class="font-semibold text-gray-700 mb-1">Status</h5>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Tersedia</span>
                    </div>
                </div>
                ${booth.deskripsi ? `
                <div>
                    <h5 class="font-semibold text-gray-700 mb-1">Deskripsi</h5>
                    <p class="text-gray-800">${booth.deskripsi}</p>
                </div>
                ` : ''}
                ${booth.fitur ? `
                <div>
                    <h5 class="font-semibold text-gray-700 mb-1">Fitur</h5>
                    <p class="text-gray-800">${booth.fitur}</p>
                </div>
                ` : ''}
            `;
            
            // Show modal
            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function selectBoothFromModal() {
            if (currentModalBoothId) {
                const boothCard = document.querySelector(`.booth-card[data-id="${currentModalBoothId}"]`);
                if (boothCard) {
                    selectBooth(boothCard);
                }
                closeDetailModal();
            }
        }

        // Strip controls
        function increaseStrip() {
            if (!selectedPaket) return;
            
            tambahStrip++;
            document.getElementById('tambahStripInput').value = tambahStrip;
            updateRingkasan();
        }

        function decreaseStrip() {
            if (tambahStrip > 0) {
                tambahStrip--;
                document.getElementById('tambahStripInput').value = tambahStrip;
                updateRingkasan();
            }
        }

        // Time Slot Selection
        function selectTimeSlot(button, time) {
            // Remove selection from all buttons
            document.querySelectorAll('.time-slot').forEach(btn => {
                btn.classList.remove('bg-pink-500', 'text-white', 'border-pink-500');
                btn.classList.add('bg-white', 'border-gray-300');
            });
            
            // Add selection to clicked button
            button.classList.add('bg-pink-500', 'text-white', 'border-pink-500');
            button.classList.remove('bg-white', 'border-gray-300');
            
            selectedTime = time;
            
            // Update hidden input
            document.getElementById('selectedTime').value = selectedTime;
            
            // Update ringkasan
            updateRingkasanWaktu();
            validateForm();
        }

        // Initialize time slots - SEMUA TERSEDIA, tidak ada disabled
        function initializeTimeSlots() {
            document.querySelectorAll('.time-slot').forEach(button => {
                // SEMUA JAM TERSEDIA, tidak ada yang disabled
                button.disabled = false;
                button.classList.add('bg-white', 'border-gray-300', 'hover:border-pink-300');
                button.classList.remove('bg-gray-300', 'cursor-not-allowed');
            });
        }

        // Update ringkasan waktu
        function updateRingkasanWaktu() {
            const dateInput = document.getElementById('tanggalInput');
            const selectedDate = dateInput.value;
            const dateObj = new Date(selectedDate);
            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            const formattedDate = dateObj.toLocaleDateString('id-ID', options);
            
            let waktuText = formattedDate;
            if (selectedTime) {
                waktuText += `, ${selectedTime}`;
            } else {
                waktuText = '-';
            }
            
            document.getElementById('ringkasanWaktu').textContent = waktuText;
        }

        // Update all ringkasan
        function updateRingkasan() {
            // Update text ringkasan
            if (selectedPaket) {
                document.getElementById('ringkasanPaket').textContent = selectedPaket.name;
                document.getElementById('hargaPaket').textContent = formatRupiah(selectedPaket.harga);
                
                const totalStrip = selectedPaket.strip + tambahStrip;
                document.getElementById('ringkasanStrip').textContent = `${totalStrip} cetakan`;
            }
            
            if (selectedBooth) {
                document.getElementById('ringkasanBooth').textContent = selectedBooth.name;
            }
            
            // Calculate additional cost
            let biayaTambahan = tambahStrip * hargaPerStrip;
            
            // Update biaya tambahan display
            document.getElementById('biayaTambahan').textContent = formatRupiah(biayaTambahan);
            
            // Show/hide tambah strip row
            const tambahStripRow = document.getElementById('tambahStripRow');
            if (biayaTambahan > 0) {
                tambahStripRow.style.display = 'flex';
                document.getElementById('hargaTambahan').textContent = formatRupiah(biayaTambahan);
            } else {
                tambahStripRow.style.display = 'none';
            }
            
            // Calculate total
            const totalHarga = (selectedPaket ? selectedPaket.harga : 0) + biayaTambahan;
            document.getElementById('totalHarga').textContent = formatRupiah(totalHarga);
        }

        // Format Rupiah
        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Validate form before enabling submit
        function validateForm() {
            const isValid = selectedPaket && selectedBooth && selectedTime;
            const submitBtn = document.getElementById('submitBtn');
            
            if (isValid) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
            
            return isValid;
        }

        // Show tiket modal
        function showTiketModal() {
            // Validate form first
            if (!validateForm()) {
                alert('Harap lengkapi semua data terlebih dahulu!');
                return;
            }
            
            // Generate random antrian number (001-999)
            const antrianNumber = Math.floor(Math.random() * 999) + 1;
            const formattedNumber = antrianNumber.toString().padStart(3, '0');
            
            // Set tiket data
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('ticketDateTime').textContent = `${today} ${selectedTime}`;
            document.getElementById('ticketBooth').textContent = selectedBooth.name;
            document.getElementById('ticketPaket').textContent = selectedPaket.name;
            document.getElementById('ticketNumber').textContent = formattedNumber;
            
            // Show modal
            document.getElementById('tiketModal').classList.remove('hidden');
        }

        function closeTiketModal() {
            document.getElementById('tiketModal').classList.add('hidden');
        }

        // Toggle mobile menu
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }

        // Initialize form validation
        validateForm();
    </script>

</body>
</html>