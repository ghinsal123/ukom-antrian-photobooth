@extends('Operator.layout')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit Reservasi</h2>

<form action="/operator/reservasi/update/{{ $data->id }}" method="POST" class="bg-white p-5 shadow rounded">
    @csrf
    @method('PUT')

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
        <label class="font-semibold">Tanggal</label>
        <input type="date" name="tanggal" class="w-full border p-2 rounded" value="{{ $data->tanggal }}">
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
