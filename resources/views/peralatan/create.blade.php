<!-- app/views/users/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Peralatan Baru</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Tambah Peralatan</h1>

<!-- if there are creation errors, they will show here -->
{!! Html::ul($errors->all()) !!}

{!! Form::open(array('url' => 'peralatan')) !!}

    <div class="form-group">
        {!! Form::label('nama', 'Nama') !!}
        {!! Form::text('nama', Input::old('nama'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', array(1 => 'Tidak rusak', 0 => 'Rusak'), Input::old('status')) !!}
    </div>

   <div class="form-group">
        {!! Form::label('ketersediaan', 'Ketersediaan') !!}
        {!! Form::select('ketersediaan', array(1 => 'Tersedia', 0 => 'Tidak tersedia'), Input::old('ketersediaan')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('lokasi', 'Lokasi') !!}
        {!! Form::text('lokasi', Input::old('lokasi'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('jenis', 'Jenis') !!}
        {!! Form::text('jenis', Input::old('jenis'), array('class' => 'form-control')) !!}
    </div>
    

    {!! Form::submit('Publish!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}

</div>
</body>
</html>