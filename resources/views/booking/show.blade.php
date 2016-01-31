<!-- app/views/nerds/show.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Booking {{ $booking->id }}</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Showing Booking #{{ $booking->id }}</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Barang:</strong> {{ $booking->id_barang }}<br>
            <strong>Pembooking:</strong> {{ $booking->id_pembooking }}<br>
            <strong>Mulai:</strong> {{ $booking->waktu_booking_mulai }}<br>
            <strong>Kembali:</strong> {{ $booking->waktu_booking_kembali }}<br>
        </p>
    </div>

</div>
</body>
</html>