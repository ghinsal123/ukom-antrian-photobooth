@extends('Operator.layout')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit Antrian</h2>

<form action="{{ route('operator.antrian.update', $data->id) }}" method="POST" class="bg-white p-5 shadow rounded">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="font-semibold">Pengguna</label>
        <select name="pengguna_id" class="w-full border p-2 rounded">
            @foreach ($pengguna as $p)
                <option value="{{ $p->id }}" @selected($p->id == $data->pengguna_id)>
                    {{ $p->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="font-semibold">Booth</label>
        <select name="booth_id" class="w-full border p-2 rounded">
            @foreach ($booth as $b)
                <option value="{{ $b->id }}" @selected($b->id == $data->booth_id)>
                    {{ $b->nama_booth }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="font-semibold">Paket</label>
        <select name="paket_id" class="w-full border p-2 rounded">
            @foreach ($paket as $p)
                <option value="{{ $p->id }}" @selected($p->id == $data->paket_id)>
                    {{ $p->nama_paket }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="font-semibold">Nomor Antrian</label>
        <input type="number" name="nomor_antrian" class="w-full border p-2 rounded"
               value="{{ $data->nomor_antrian }}">
    </div>

    <div class="mb-3">
        <label class="font-semibold">Tanggal</label>
        <input type="date" name="tanggal" class="w-full border p-2 rounded"
               value="{{ $data->tanggal }}">
    </div>

    <div class="mb-3">
        <label class="font-semibold">Status</label>
        <select name="status" class="w-full border p-2 rounded">
            <option value="menunggu" @selected($data->status == 'menunggu')>Menunggu</option>
            <option value="proses" @selected($data->status == 'proses')>Proses</option>
            <option value="selesai" @selected($data->status == 'selesai')>Selesai</option>
            <option value="dibatalkan" @selected($data->status == 'dibatalkan')>Dibatalkan</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="font-semibold">Catatan</label>
        <textarea name="catatan" class="w-full border p-2 rounded">{{ $data->catatan }}</textarea>
    </div>

    <button class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
</form>
@endsection
