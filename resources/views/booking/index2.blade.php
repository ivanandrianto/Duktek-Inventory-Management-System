<!DOCTYPE html>
<html>
<head>
    <title>Look! I'm CRUDding</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>All the Booking</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>Nama Pembooking</td>
            <td>Nama Peralatan</td>
            <td>Mulai</td>
            <td>Kembali</td>
        </tr>
    </thead>
    <tbody>
        @foreach($booking as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->pengguna->nama }}</td>
            <td>{{ $value->peralatan->nama }}</td>
            <td>{{ $value->waktu_booking_mulai }}</td>
            <td>{{ $value->waktu_booking_kembali }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="table table-striped table-bordered">
</div>
</body>
</html>