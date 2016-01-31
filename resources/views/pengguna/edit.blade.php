<!-- app/views/nerds/edit.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Look! I'm CRUDding</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Edit {{ $pengguna->name }}</h1>

<!-- if there are creation errors, they will show here -->
{!! Html::ul($errors->all()) !!}

{!! Form::model($pengguna, array('route' => array('pengguna.update', $pengguna->id), 'method' => 'PUT')) !!}

    <div class="form-group">
        {!! Form::label('nama', 'Nama') !!}
        {!! Form::text('nama', null, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('alamat', 'Alamat') !!}
        {!! Form::text('alamat', null, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('no_telp', 'No Telp') !!}
        {!! Form::text('no_telp', null, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('jenis', 'Jenis') !!}
        {!! Form::text('jenis', null, array('class' => 'form-control')) !!}
    </div>

    {!! Form::submit('Edit Pengguna!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}

</div>
</body>
</html>