@extends('Operator.layout')

@section('content')
<div class="max-w-3xl mx-auto mt-8">

    <h2 class="text-4xl font-extrabold mb-6 text-gray-800 text-center">Tambah Antrian</h2>

    {{-- Tampilkan error Laravel --}}
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

       {{-- STEP 1: Data Customer --}}
        <div id="step1">
            <h3 class="text-2xl font-bold text-pink-500 mb-4">Step 1: Data Customer</h3>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Customer <span class="text-red-500">*</span></label>
                <input type="text" id="nama_pengguna" name="nama_pengguna" placeholder="Ketik nama customer..."
                    value="{{ old('nama_pengguna') }}"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400"
                    required>
            </div>

            <label class="block text-gray-700 font-semibold mb-2">
                Nomor Telepon <span class="text-red-500">*</span>
            </label>
            <div class="flex">
                <span class="px-4 py-3 bg-gray-200 border border-gray-300 rounded-l-lg font-semibold">+62</span>
                <input type="text" id="no_telp" name="no_telp" placeholder="8123456789"
                    value="{{ old('no_telp') }}"
                    class="w-full border border-gray-300 p-3 rounded-r-lg focus:outline-none focus:ring-2 focus:ring-pink-400"
                    required>
            </div>

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
        
        {{-- STEP 2: Pilih Booth & Paket --}}
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
                <select name="paket_id" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400" required>
                    <option value="" disabled selected>-- Pilih Paket --</option>
                    @foreach ($paket as $p)
                        <option value="{{ $p->id }}" {{ old('paket_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_paket }}</option>
                    @endforeach
                </select>
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

        {{-- Validasi Step 1 --}}
        <script>
        const nama = document.getElementById('nama_pengguna');
        const telp = document.getElementById('no_telp');
        const btnStep1 = document.getElementById('btnStep1');

        function validateStep1() {
            const validNama = nama.value.trim().length > 0;
            const validTelp = /^[0-9]+$/.test(telp.value.trim()) && telp.value.trim().length >= 9;

            if (validNama && validTelp) {
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

        nama.addEventListener('input', validateStep1);
        telp.addEventListener('input', validateStep1);


        // Validasi Step 2
        const booth = document.querySelector('select[name="booth_id"]');
        const paket = document.querySelector('select[name="paket_id"]');
        const btnStep2 = document.getElementById('btnStep2');

        function validateStep2() {
            if (booth.value && paket.value) {
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
        }

        booth.addEventListener('change', validateStep2);
        paket.addEventListener('change', validateStep2);
        </script>

        {{-- STEP 3: Catatan & Konfirmasi --}}
        <div id="step3" class="hidden">
            <h3 class="text-2xl font-bold text-pink-500 mb-4">Step 3: Catatan & Konfirmasi</h3>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Tanggal & Waktu</label>
                <p class="text-gray-600 text-lg italic">{{ now('Asia/Jakarta')->format('d M Y H:i') }}</p>
                <input type="hidden" name="tanggal" value="{{ now('Asia/Jakarta')->format('Y-m-d H:i:s') }}">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-3">Pilih Jam</label>
                <div class="grid grid-cols-4 gap-3">
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

            <div class="flex gap-4 mt-4">
                <button type="button" onclick="nextStep(2)"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg">
                    ← Kembali
                </button>
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

    // ---- 1. Step Navigation ----
    window.nextStep = function(step) {
        document.getElementById('step1').classList.add('hidden');
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step3').classList.add('hidden');
        document.getElementById('step' + step).classList.remove('hidden');
    };

    // ---- 2. Pilih Jam (Select button) ----
    const selectedJamInput = document.getElementById('selectedJam');

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
        });
    });

    // ---- 3. Aktifkan Jam Old Value ----
    if (selectedJamInput.value) {
        const oldBtn = document.querySelector(`.jamBtn[data-jam="${selectedJamInput.value}"]`);
        if (oldBtn && !oldBtn.disabled) {
            oldBtn.classList.remove('bg-gray-300', 'text-gray-800');
            oldBtn.classList.add('bg-purple-700', 'text-white');
        }
    }

    // ---- 4. JAM PER BOOTH FIX ----
    const jamTerpakai = @json($jamTerpakai);
    const jamSekarang = "{{ $jamSekarang }}"; // ← dari controller
    const boothSelect = document.querySelector('select[name="booth_id"]');

    boothSelect.addEventListener('change', function () {
        const boothId = this.value;
        const jamTidakBisa = jamTerpakai[boothId] ?? [];

        document.querySelectorAll('.jamBtn').forEach(btn => {
            const jam = btn.dataset.jam;

            // Reset default state
            btn.disabled = false;
            btn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            btn.classList.add('bg-gray-300', 'text-gray-800');

            // 1. Disable jam yang sudah dipakai
            if (jamTidakBisa.includes(jam)) {
                btn.disabled = true;
                btn.classList.remove('bg-gray-300', 'text-gray-800');
                btn.classList.add('bg-gray-400', 'cursor-not-allowed');
                return;
            }

            // 2. Disable jam yang sudah lewat
            if (jam < jamSekarang) {
                btn.disabled = true;
                btn.classList.remove('bg-gray-300', 'text-gray-800');
                btn.classList.add('bg-gray-400', 'cursor-not-allowed');
                return;
            }
        });

        // Reset jam yang dipilih jika booth diganti
        selectedJamInput.value = "";
        resetJamSelection();
    });
});
</script>
@endsection
