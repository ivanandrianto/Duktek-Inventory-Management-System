<!-- app/views/users/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pengguna Baru</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Tambah Pengguna</h1>

<!-- if there are creation errors, they will show here -->
{!! Html::ul($errors->all()) !!}

{!! Form::open(array('url' => 'pengguna')) !!}

    <div class="form-group">
        {!! Form::label('nama', 'Nama') !!}
        {!! Form::text('nama', Input::old('nama'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('alamat', 'Alamat') !!}
        {!! Form::text('alamat', Input::old('alamat'), array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('no_telp', 'No Telp') !!}
        {!! Form::text('no_telp', Input::old('no_telp'), array('class' => 'form-control')) !!}
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