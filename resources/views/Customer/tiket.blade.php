<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tiket Antrian - FlashFrame PhotoBooth</title>
    @vite('resources/css/app.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.5/JsBarcode.all.min.js"></script>
    <style>
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .tiket-wrapper {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            animation: fadeIn 0.3s;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 16px;
            max-width: 500px;
            width: 100%;
            animation: slideIn 0.3s;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body style="background: linear-gradient(to bottom, #fdf2f8, #ffffff); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem;">
    
    <!-- Modal Batalkan Antrian -->
    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Batalkan Antrian</h3>
            <p class="text-gray-600 mb-6">Anda yakin ingin membatalkan antrian ini? Silakan pilih alasan pembatalan.</p>
            
            <form action="{{ route('customer.antrian.delete', $antrian->id) }}" method="POST" id="cancelForm">
                @csrf
                @method('DELETE')
                
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-3">Alasan Pembatalan <span class="text-red-500">*</span></label>
                    <select name="alasan" required class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:outline-none">
                        <option value="">Pilih alasan...</option>
                        <option value="Berhalangan hadir">Berhalangan hadir</option>
                        <option value="Salah pilih waktu">Salah pilih waktu</option>
                        <option value="Salah pilih booth">Salah pilih booth</option>
                        <option value="Perubahan rencana">Perubahan rencana</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-3">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan_tambahan" rows="3" 
                              placeholder="Tulis catatan tambahan jika diperlukan..."
                              class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:outline-none resize-none"></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeModal()"
                            class="flex-1 px-5 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 px-5 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-semibold hover:from-red-600 hover:to-red-700 transition-all shadow-lg">
                        Batalkan Antrian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="tiket-wrapper" style="max-width: 22rem; width: 100%; background: white; padding: 1.25rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 0.75rem;">
        
        <!-- HEADER -->
        <div style="text-align: center; margin-bottom: 0.75rem;">
            <h2 style="font-size: 1.4rem; font-weight: bold; color: #ec4899; margin: 0;">Tiket Antrian</h2>
        </div>

        <!-- INFO TANGGAL & WAKTU & STATUS -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; gap: 0.5rem;">
            <div style="text-align: left;">
                <p style="font-size: 0.7rem; color: #374151; margin: 0; font-weight: 500;">
                    {{ \Carbon\Carbon::parse($antrian->tanggal)->locale('id')->isoFormat('YYYY-MM-DD HH:mm') }}
                </p>
            </div>
            
            <div>
                @if($antrian->status == 'menunggu')
                    <span style="color: #f59e0b; background: #fef3c7; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: 600;">Menunggu</span>
                @elseif($antrian->status == 'proses')
                    <span style="color: #2563eb; background: #dbeafe; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: 600;">Diproses</span>
                @elseif($antrian->status == 'sesi_foto')
                    <span style="color: #2563eb; background: #dbeafe; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: 600;">Sesi Foto</span>
                @elseif($antrian->status == 'selesai')
                    <span style="color: #059669; background: #d1fae5; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: 600;">Selesai</span>
                @elseif($antrian->status == 'kadaluarsa')
                    <span style="color: #9333ea; background: #f3e8ff; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: 600;">Kadaluarsa</span>
                @else
                    <span style="color: #dc2626; background: #fee2e2; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem; font-weight: 600;">Dibatalkan</span>
                @endif
            </div>
        </div>

        <!-- INFO CUSTOMER SECTION -->
        <div style="margin-bottom: 0.75rem;">
            <div style="margin-bottom: 0.3rem;">
                <p style="margin: 0; font-size: 0.7rem; color: #6b7280; font-weight: 600;">Customer: <span style="color: #111827;">{{ $antrian->pengguna->nama_pengguna ?? '-' }}</span></p>
            </div>

            <div style="margin-bottom: 0.3rem;">
                <p style="margin: 0; font-size: 0.7rem; color: #6b7280; font-weight: 600;">Telepon: <span style="color: #111827;">{{ $antrian->pengguna->no_telp ?? '-' }}</span></p>
            </div>

            <div style="margin-bottom: 0.3rem;">
                <p style="margin: 0; font-size: 0.7rem; color: #6b7280; font-weight: 600;">Booth: <span style="color: #111827;">{{ $antrian->booth->nama_booth ?? '-' }}</span></p>
            </div>

            <div style="margin-bottom: 0.3rem;">
                <p style="margin: 0; font-size: 0.7rem; color: #6b7280; font-weight: 600;">Paket: <span style="color: #111827;">{{ $antrian->paket->nama_paket ?? '-' }}</span></p>
            </div>

            @if(isset($antrian->strip))
            <div>
                <p style="margin: 0; font-size: 0.7rem; color: #6b7280; font-weight: 600;">Strip: <span style="color: #111827;">{{ $antrian->strip }} strip</span></p>
            </div>
            @endif
        </div>

        <!-- NOMOR ANTRIAN BESAR -->
        <div style="text-align: center; margin: 0.6rem 0;">
            <p style="font-size: 3.5rem; font-weight: bold; color: #ec4899; margin: 0; line-height: 1;">
                {{ str_pad($antrian->nomor_antrian, 3, '0', STR_PAD_LEFT) }}
            </p>
        </div>

        <!-- BARCODE -->
        <div style="margin: 0.75rem 0; padding: 0.5rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; background: white; overflow: hidden;">
            <svg id="barcode" style="width: 100%; height: auto; display: block; max-width: 100%;"></svg>
        </div>

        <!-- PESAN -->
        <div style="text-align: center; margin-bottom: 0.75rem;">
            <p style="color: #6b7280; font-size: 0.7rem; margin: 0;">
                Silakan cetak barcode ini.
            </p>
        </div>

        <!-- BUTTONS -->
        <div style="margin-top: 0.75rem; display: flex; flex-direction: column; gap: 0.45rem;" class="no-print">
            <!-- Tombol Kembali (Biru) -->
            <a href="{{ route('customer.landingpage') }}"
               style="width: 100%; display: block; text-align: center; padding: 0.6rem; background: #3b82f6; color: white; border-radius: 0.5rem; text-decoration: none; font-weight: 600; font-size: 0.75rem;">
                Kembali
            </a>

            <!-- Tombol Cetak PDF (Pink) -->
            <button onclick="window.print()"
                    style="width: 100%; padding: 0.6rem; background: #ec4899; color: white; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.75rem; cursor: pointer;">
                Cetak PDF
            </button>

            <!-- Tombol Batalkan Antrian (Hijau) - hanya tampil jika status menunggu -->
            @if($antrian->status === 'menunggu')
                <button type="button" onclick="openModal()"
                        style="width: 100%; padding: 0.6rem; background: #10b981; color: white; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.75rem; cursor: pointer;">
                    Batalkan Antrian
                </button>
            @endif
        </div>

    </div>
    
    <script>
        // Generate Barcode
        document.addEventListener('DOMContentLoaded', function() {
            const barcodeValue = "{{ $antrian->barcode ?? 'DEFAULT12345' }}";
            
            try {
                JsBarcode("#barcode", barcodeValue, {
                    format: "CODE128",
                    width: 1.5,
                    height: 50,
                    displayValue: false,
                    margin: 0,
                    background: "#ffffff",
                    lineColor: "#000000"
                });
            } catch (error) {
                console.error('Error generating barcode:', error);
                document.getElementById('barcode').innerHTML = '<text x="50%" y="50%" text-anchor="middle" fill="#dc2626" font-size="14">Barcode Error: ' + barcodeValue + '</text>';
            }
        });

        // Modal Functions
        function openModal() {
            document.getElementById('cancelModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('cancelModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('cancelModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>