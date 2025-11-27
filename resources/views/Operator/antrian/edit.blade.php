@extends('Operator.layout')

@section('content')
<div class="max-w-3xl mx-auto mt-8">
    <h2 class="text-4xl font-extrabold mb-6 text-gray-800 text-center">Edit Antrian</h2>

    @php
        // cek jika status antrian sudah dibatalkan
        $isCanceled = $data->status === 'dibatalkan';
        $grayClass = $isCanceled ? 'bg-gray-200 text-gray-600 cursor-not-allowed' : '';
    @endphp

    <form action="{{ route('operator.antrian.update', $data->id) }}" method="POST"
          class="bg-white p-8 shadow-lg rounded-xl space-y-6">

        @csrf
        @method('PUT')

        <!-- nama pengguna (readonly) -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Pengguna</label>
            <input type="text"
                   value="{{ $data->pengguna->nama_pengguna }}"
                   class="w-full border border-gray-300 p-3 rounded-lg bg-gray-100 cursor-not-allowed"
                   readonly>
        </div>

        <!-- nomor telepon (readonly) -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
            <input type="text"
                   value="{{ $data->pengguna->no_telp ?? '-' }}"
                   class="w-full border border-gray-300 p-3 rounded-lg bg-gray-100 cursor-not-allowed"
                   readonly>
        </div>

        <!-- pilih booth -->
        <select name="booth_id"
                class="w-full border border-gray-300 p-3 rounded-lg {{ $grayClass }}"
                @disabled($isCanceled)>
            @foreach ($booth as $b)
                <option value="{{ $b->id }}" @selected($b->id == $data->booth_id)>
                    {{ $b->nama_booth }}
                </option>
            @endforeach
        </select>

        <!-- pilih paket -->
        <select name="paket_id"
                class="w-full border border-gray-300 p-3 rounded-lg {{ $grayClass }}"
                @disabled($isCanceled)>
            @foreach ($paket as $p)
                <option value="{{ $p->id }}" @selected($p->id == $data->paket_id)>
                    {{ $p->nama_paket }}
                </option>
            @endforeach
        </select>

        <!-- nomor antrian (readonly) -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Nomor Antrian</label>
            <input type="text"
                   value="{{ $data->nomor_antrian }}"
                   class="w-full border border-gray-300 p-3 rounded-lg bg-gray-100 cursor-not-allowed"
                   readonly>
        </div>

        <!-- tanggal dan waktu otomatis -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Tanggal & Waktu</label>

            <p class="text-gray-600 text-lg italic">
                {{ now('Asia/Jakarta')->format('d M Y H:i') }}
            </p>

            <input type="hidden" name="tanggal"
                   value="{{ now('Asia/Jakarta')->format('Y-m-d H:i:s') }}">
        </div>

        <!-- status antrian -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Status</label>
            <select name="status"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-pink-400"
                    @disabled($isCanceled)>
                <option value="menunggu" @selected($data->status == 'menunggu')>Menunggu</option>
                <option value="proses" @selected($data->status == 'proses')>Proses</option>
                <option value="selesai" @selected($data->status == 'selesai')>Selesai</option>
                <option value="dibatalkan" @selected($data->status == 'dibatalkan')>Dibatalkan</option>
            </select>

            @if ($isCanceled)
                <p class="text-red-500 text-sm mt-1 italic">
                    Status tidak bisa diubah karena antrian sudah dibatalkan.
                </p>
            @endif
        </div>

        <!-- catatan -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Catatan</label>
            <textarea name="catatan" rows="4"
                      class="w-full border border-gray-300 p-3 rounded-lg {{ $grayClass }} resize-none"
                      @disabled($isCanceled)>{{ $data->catatan }}</textarea>
        </div>

        <!-- tombol  -->
        <div class="flex gap-4">
            <button type="submit"
                    class="flex-1 bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 rounded-lg transition duration-300">
                Edit Antrian
            </button>

            <a href="{{ route('operator.antrian.index') }}"
               class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg text-center transition duration-300">
               Batal
            </a>
        </div>

    </form>
</div>
@endsection
