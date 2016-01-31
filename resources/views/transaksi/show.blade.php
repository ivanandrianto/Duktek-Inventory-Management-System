<!-- app/views/nerds/show.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi {{ $transaksi->id }}</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Showing Transaksi {{ $transaksi->id }}</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Barang:</strong> {{ $transaksi->id_barang }}</br>
            <strong>Waktu Pinjam:</strong> {{ $transaksi->waktu_pinjam }}<br>
            <strong>Rencana Kembali:</strong> {{ $transaksi->waktu_rencana_kembali }}<br>
            <strong>Kembali:</strong> {{ $transaksi->waktu_kembali }}<br>
        </p>
    </div>

</div>
</body>
</html>