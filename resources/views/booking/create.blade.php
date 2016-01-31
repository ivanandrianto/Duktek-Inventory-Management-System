<!-- app/views/users/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Buat Booking Baru</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Booking Baru</h1>

<!-- if there are creation errors, they will show here -->
{!! Html::ul($errors->all()) !!}

{!! Form::open(array('url' => 'booking')) !!}

    <div class="form-group">
        {!! Form::label('id_barang', 'Barang') !!}
        {!! Form::text('id_barang', Input::old('id_barang'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('waktu_booking_mulai', 'Waktu Mulai') !!}
        {!! Form::input('date', 'waktu_booking_mulai_date', Input::old('waktu_booking_mulai_date'), array('class' => 'form-control')) !!}
        {!! Form::input('time', 'waktu_booking_mulai_time', Input::old('waktu_booking_mulai_time'), array('class' => 'form-control')) !!}
    </div>

     <div class="form-group">
        {!! Form::label('waktu_booking_selesai', 'Waktu Selesai') !!}
        {!! Form::input('date', 'waktu_booking_selesai_date', Input::old('waktu_booking_selesai_date'), array('class' => 'form-control')) !!}
        {!! Form::input('time', 'waktu_booking_selesai_time', Input::old('waktu_booking_selesai_time'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('id_pembooking', 'Pembooking') !!}
        {!! Form::text('id_pembooking', Input::old('id_pembooking'), array('class' => 'form-control')) !!}
    </div>

    {!! Form::submit('Booking!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}

</div>
</body>
</html>