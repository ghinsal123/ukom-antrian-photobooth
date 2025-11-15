@extends('admin.layouts.app')
@section('title', 'Laporan')

@section('content')
<h2>Laporan Antrian</h2>
<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Booth</th>
            <th>Paket</th>
            <th>Jumlah Antrian</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>1</td><td>13 Nov 2025</td><td>Booth 1</td><td>Paket Silver</td><td>10</td></tr>
        <tr><td>2</td><td>12 Nov 2025</td><td>Booth 2</td><td>Paket Gold</td><td>7</td></tr>
        <tr><td>3</td><td>11 Nov 2025</td><td>Booth 3</td><td>Paket Diamond</td><td>9</td></tr>
    </tbody>
</table>
@endsection
