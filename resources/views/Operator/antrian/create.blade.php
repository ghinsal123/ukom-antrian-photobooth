@extends('Operator.layout')

@section('content')
<div class="max-w-3xl mx-auto mt-8">

    <h2 class="text-4xl font-extrabold mb-6 text-gray-800 text-center">Tambah Antrian</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('operator.antrian.store') }}" method="POST"
          class="bg-white p-8 shadow-lg rounded-xl space-y-6">
        @csrf

        {{-- STEP 1 --}}
        <div id="step1">
            <h3 class="text-2xl font-bold text-pink-500 mb-4">Step 1: Data Customer</h3>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Customer <span class="text-red-500">*</span></label>
                <input type="text" id="nama_pengguna" name="nama_pengguna" placeholder="Ketik nama customer..."
                    value="{{ old('nama_pengguna') }}"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400"
                    required>
            </div>

            <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
            <div class="flex">
                <span class="px-4 py-3 bg-gray-200 border border-gray-300 rounded-l-lg font-semibold">+62</span>
                <input type="text" id="no_telp" name="no_telp" placeholder="8123456789"
                    value="{{ old('no_telp') }}"
                    class="w-full border border-gray-300 p-3 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-pink-400"
                    required>
            </div>
            <p id="errorTelp" class="text-red-500 text-sm mt-1"></p>

            <div class="flex gap-3 mt-5">
                <a href="{{ route('operator.antrian.index') }}"
                   class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg text-center">
                    ← Kembali ke Daftar
                </a>
                <button type="button" id="btnStep1"
                        class="flex-1 bg-pink-300 text-white font-bold py-3 rounded-lg cursor-not-allowed"
                        disabled>
                    Lanjut ke Step 2 →
                </button>
            </div>
        </div>

        {{-- STEP 2 --}}
        <div id="step2" class="hidden">
            <h3 class="text-2xl font-bold text-pink-500 mb-4">Step 2: Pilih Booth & Paket</h3>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Booth <span class="text-red-500">*</span></label>
                <select name="booth_id" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                    <option value="" disabled selected>-- Pilih Booth --</option>
                    @foreach ($booth as $b)
                        <option value="{{ $b->id }}" {{ old('booth_id') == $b->id ? 'selected' : '' }}>{{ $b->nama_booth }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Paket <span class="text-red-500">*</span></label>
            <select name="paket_id" class="w-full border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                <option value="" disabled selected>-- Pilih Paket --</option>
                @foreach ($paket as $p)
                    <option value="{{ $p->id }}" 
                            data-harga="{{ $p->harga }}"
                            data-deskripsi="{{ $p->deskripsi }}"
                            {{ old('paket_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_paket }} - Rp{{ number_format($p->harga,0,',','.') }} | {{ $p->deskripsi }}
                    </option>
                @endforeach
            </select>
            </div>
         <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Tambah Strip Opsional (Rp10.000 / strip)</label>
            <input type="number" id="stripJumlah" name="stripJumlah" min="0" value="0"
                class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400">
           </div>
            <div class="flex gap-4 mt-6">
                <button type="button" onclick="nextStep(1)"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg">
                    ← Kembali
                </button>

                <button type="button" id="btnStep2"
                        class="flex-1 bg-pink-300 text-white font-bold py-3 rounded-lg cursor-not-allowed"
                        disabled>
                    Lanjut ke Step 3 →
                </button>
            </div>
        </div>

        {{-- STEP 3 --}}
        <div id="step3" class="hidden">
            <h3 class="text-2xl font-bold text-pink-500 mb-4">Step 3: Catatan & Konfirmasi</h3>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Reservasi <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal"
                       value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                       class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 bg-gray-100 cursor-not-allowed"
                       readonly>
                <p class="text-gray-500 text-sm mt-1">* Tanggal otomatis hari ini dan tidak bisa diubah</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-3">Pilih Jam (Sesi 10 menit) <span class="text-red-500">*</span></label>
                <p class="text-gray-500 text-sm mb-1">Jam operasional: 09:00 - 21:30</p>
                <div class="grid grid-cols-4 gap-3 max-h-64 overflow-y-auto border p-3 rounded-lg">
                    @foreach ($jamList as $jam)
                        @php
                            $disabled = in_array($jam, $jamTerpakai) || $jam < $jamSekarang;
                        @endphp
                        <button type="button"
                                class="jamBtn {{ $disabled ? 'bg-gray-400 cursor-not-allowed' : 'bg-gray-300 text-gray-800' }} py-2 rounded-lg text-sm font-semibold"
                                data-jam="{{ $jam }}" {{ $disabled ? 'disabled' : '' }}>
                            {{ $jam }}
                        </button>
                    @endforeach
                </div>
                <input type="hidden" name="jam" id="selectedJam" value="{{ old('jam') }}">
            </div>

            <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                <h4 class="text-lg font-bold text-gray-700 mb-2">Ringkasan Pemesanan</h4>
               <ul class="text-gray-700 text-sm space-y-1">
                    <li>Booth: <span id="summaryBooth">{{ old('booth_id') ? $booth->where('id', old('booth_id'))->first()->nama_booth : '-' }}</span></li>
                    <li>Paket: <span id="summaryPaket">{{ old('paket_id') ? $paket->where('id', old('paket_id'))->first()->nama_paket : '-' }}</span></li>
                    <li>Deskripsi Paket: <span id="summaryDeskripsi">-</span></li>
                    <li>Harga Paket: <span id="summaryHargaPaket">Rp0</span></li>
                    <li>Strip Opsional: <span id="summaryStrip">0</span> strip</li>
                    <li>Harga Strip: <span id="summaryHargaStrip">Rp0</span></li>
                    <li>Total Harga: <span id="summaryTotalHarga">Rp0</span></li>
                    <li>Tanggal: <span id="summaryTanggal">{{ \Carbon\Carbon::now()->format('Y-m-d') }}</span></li>
                    <li>Jam: <span id="summaryJam">{{ old('jam') ?? '-' }}</span></li>
                </ul>
            </div>

            <div class="flex gap-4 mt-4">
                <button type="button" onclick="nextStep(2)"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg">
                    ← Kembali
                </button>
                <input type="hidden" name="catatan" id="catatanInput" value="">
                <button type="submit"
                        class="flex-1 bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-lg">
                    Simpan Antrian ✓
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // --- Step Navigation ---
    window.nextStep = function(step) {
        document.getElementById('step1').classList.add('hidden');
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step3').classList.add('hidden');
        document.getElementById('step' + step).classList.remove('hidden');
    };

    // --- Validasi Step 1 ---
    const telp = document.getElementById('no_telp');
    const btnStep1 = document.getElementById('btnStep1');
    const errorTelp = document.getElementById('errorTelp');

    function validateStep1() {
        const no = telp.value.trim();
        let validTelp = true;
        errorTelp.textContent = "";

        if (no === "") validTelp = false;
        else if (!/^[0-9]+$/.test(no)) {
            errorTelp.textContent = "Nomor telepon hanya boleh berisi angka.";
            validTelp = false;
        } else if (no.startsWith("0")) {
            errorTelp.textContent = "Tidak boleh dimulai dengan angka 0. Contoh: 8123456789";
            validTelp = false;
        } else if (no.length < 10) {
            errorTelp.textContent = "Nomor minimal 10 digit.";
            validTelp = false;
        } else if (no.length > 15) {
            errorTelp.textContent = "Nomor maksimal 15 digit.";
            validTelp = false;
        }

        if (no.length > 0 && validTelp) {
            btnStep1.disabled = false;
            btnStep1.classList.remove('bg-pink-300', 'cursor-not-allowed');
            btnStep1.classList.add('bg-pink-500', 'hover:bg-pink-600');
            btnStep1.onclick = () => nextStep(2);
        } else {
            btnStep1.disabled = true;
            btnStep1.classList.add('bg-pink-300', 'cursor-not-allowed');
            btnStep1.classList.remove('bg-pink-500', 'hover:bg-pink-600');
            btnStep1.onclick = null;
        }
    }
    telp.addEventListener('input', validateStep1);

    // --- Validasi Step 2 ---
    const boothSelect = document.querySelector('select[name="booth_id"]');
    const paketSelect = document.querySelector('select[name="paket_id"]');
    const btnStep2 = document.getElementById('btnStep2');
    const summaryBooth = document.getElementById('summaryBooth');
    const summaryPaket = document.getElementById('summaryPaket');
    const summaryDeskripsi = document.getElementById('summaryDeskripsi');
    const stripInput = document.getElementById('stripJumlah');
    const summaryStrip = document.getElementById('summaryStrip');
    const summaryTotalHarga = document.getElementById('summaryTotalHarga');
    const summaryJam = document.getElementById('summaryJam');
    const selectedJamInput = document.getElementById('selectedJam');

function updateSummary() {
    const paketOption = paketSelect.selectedOptions[0];
    const paketNama = paketOption?.text.split(' - ')[0] || '-';
    const paketDeskripsi = paketOption?.dataset.deskripsi || '-';
    const paketHarga = parseInt(paketOption?.dataset.harga) || 0;

    const stripJumlah = parseInt(stripInput.value) || 0;
    const stripHarga = stripJumlah * 10000;
    const totalHarga = paketHarga + stripHarga;

    // --- Update ringkasan visual ---
    summaryBooth.textContent = boothSelect.selectedOptions[0]?.text || '-';
    summaryPaket.textContent = paketNama;
    summaryDeskripsi.textContent = paketDeskripsi;
    summaryHargaPaket.textContent = 'Rp' + paketHarga.toLocaleString('id-ID');
    summaryStrip.textContent = stripJumlah;
    summaryHargaStrip.textContent = 'Rp' + stripHarga.toLocaleString('id-ID');
    summaryTotalHarga.textContent = 'Rp' + totalHarga.toLocaleString('id-ID');
    summaryJam.textContent = selectedJamInput.value || '-';

    // --- Catatan untuk database: hanya harga, strip, dan deskripsi paket ---
    const catatanText = 
        `Deskripsi Paket: ${paketDeskripsi}\n` +
        `Strip: ${stripJumlah} strip\n` +
        `Harga Strip: Rp${stripHarga.toLocaleString('id-ID')}\n` +
        `Harga Paket: Rp${paketHarga.toLocaleString('id-ID')}\n` +
        `Total Harga: Rp${totalHarga.toLocaleString('id-ID')}\n` +
        `Jam: ${selectedJamInput.value || '-'}`;

    document.getElementById('catatanInput').value = catatanText;
}

    stripInput.addEventListener('input', updateSummary);
    function validateStep2() {
        if (boothSelect.value && paketSelect.value) {
            btnStep2.disabled = false;
            btnStep2.classList.remove('bg-pink-300', 'cursor-not-allowed');
            btnStep2.classList.add('bg-pink-500', 'hover:bg-pink-600');
            btnStep2.onclick = () => nextStep(3);
        } else {
            btnStep2.disabled = true;
            btnStep2.classList.add('bg-pink-300', 'cursor-not-allowed');
            btnStep2.classList.remove('bg-pink-500', 'hover:bg-pink-600');
            btnStep2.onclick = null;
        }
        updateSummary();
    }
    boothSelect.addEventListener('change', () => {
        validateStep2();
        handleJamPerBooth();
    });
    paketSelect.addEventListener('change', validateStep2);

    // --- Pilih Jam ---
    function resetJamSelection() {
        document.querySelectorAll('.jamBtn').forEach(btn => {
            btn.classList.remove('bg-purple-700', 'text-white');
            btn.classList.add('bg-gray-300', 'text-gray-800');
        });
    }

    document.querySelectorAll('.jamBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.disabled) return;
            resetJamSelection();
            btn.classList.remove('bg-gray-300', 'text-gray-800');
            btn.classList.add('bg-purple-700', 'text-white');
            selectedJamInput.value = btn.dataset.jam;
            updateSummary();
        });
    });

    if (selectedJamInput.value) {
        const oldBtn = document.querySelector(`.jamBtn[data-jam="${selectedJamInput.value}"]`);
        if (oldBtn && !oldBtn.disabled) {
            oldBtn.classList.remove('bg-gray-300', 'text-gray-800');
            oldBtn.classList.add('bg-purple-700', 'text-white');
        }
    }

    // --- JAM PER BOOTH FIX ---
    const jamTerpakai = @json($jamTerpakai);
    const jamSekarang = "{{ $jamSekarang }}";

    function handleJamPerBooth() {
        const boothId = boothSelect.value;
        const jamTidakBisa = jamTerpakai[boothId] ?? [];

        document.querySelectorAll('.jamBtn').forEach(btn => {
            const jam = btn.dataset.jam;
            btn.disabled = false;
            btn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            btn.classList.add('bg-gray-300', 'text-gray-800');

            if (jamTidakBisa.includes(jam) || jam < jamSekarang) {
                btn.disabled = true;
                btn.classList.remove('bg-gray-300', 'text-gray-800');
                btn.classList.add('bg-gray-400', 'cursor-not-allowed');
            }
        });

        selectedJamInput.value = "";
        resetJamSelection();
        updateSummary();
    }

    // Inisialisasi ringkasan awal
    updateSummary();
});
</script>
@endsection
