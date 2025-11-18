@extends('admin.layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">

    <h2 class="text-xl font-bold mb-4">Log Aktivitas</h2>

    @if(session('success'))
        <div class="bg-green-100 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 border">#</th>
                <th class="p-3 border">Pengguna</th>
                <th class="p-3 border">Aksi</th>
                <th class="p-3 border">Keterangan</th>
                <th class="p-3 border">Tanggal</th>
                <th class="p-3 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td class="p-3 border">{{ $log->id }}</td>
                <td class="p-3 border">{{ $log->pengguna->nama ?? '-' }}</td>
                <td class="p-3 border">{{ $log->aksi }}</td>
                <td class="p-3 border">{{ Str::limit($log->keterangan, 40) }}</td>
                <td class="p-3 border">{{ $log->created_at->format('d M Y H:i') }}</td>
                <td class="p-3 border">
                    <a href="{{ route('admin.log.show', $log->id) }}" class="text-blue-600">Detail</a>

                    <form action="{{ route('admin.log.destroy', $log->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus log ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $logs->links() }}

</div>
@endsection
