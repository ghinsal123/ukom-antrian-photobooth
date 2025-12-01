<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Antrian #{{ $data->nomor_antrian }} - {{ $data->pengguna->nama_pengguna ?? 'Customer' }}</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
            font-size: 12px;
        }
        .card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
        }
        .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #d63384;
            margin-bottom: 5px;
        }
        .logo {
            text-align: center;
            margin-bottom: 15px;
        }
        .logo img {
            width: 80px;     
            height: auto;
        }
        .barcode {
            text-align: center;
            margin: 20px 0;
        }
        .big-number {
            font-size: 55px;
            text-align: center;
            font-weight: bold;
            color: #d63384;
        }
        p { margin: 5px 0; }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="logo">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo">
    </div>

    <p><strong>Reservasi:</strong> {{ $data->tanggal }} {{ $data->jam }}</p>
    <p><strong>Status:</strong> {{ ucfirst($data->status) }}</p>

    <p><strong>Customer:</strong> {{ $data->pengguna->nama_pengguna ?? '-' }}</p>
    <p><strong>Telepon:</strong> {{ $data->pengguna->no_telp ?? '-' }}</p>
    <p><strong>Booth:</strong> {{ $data->booth->nama_booth }}</p>
    <p><strong>Paket:</strong> {{ $data->paket->nama_paket }}</p>

    <div class="big-number">{{ $data->nomor_antrian }}</div>

    @if($barcodeImageBase64)
        <div class="barcode">
            <img src="{{ $barcodeImageBase64 }}" width="250">
        </div>
    @endif

    <div class="footer">
        Segera tunjukkan barcode ini kepada operator booth, nomor antrian bisa kadaluarsa jika tidak segera diproses.
    </div>
</div>

</body>
</html>
