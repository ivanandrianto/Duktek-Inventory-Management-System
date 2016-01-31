<!-- app/views/admin/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Look! I'm CRUDding</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <script type="text/javascript" src="{{ URL::asset('assets/js/jquery-1.8.2.js') }}"></script>
    <script type="text/javascript" src="{{ url('/assets/js/jquery-ui.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>
    $(document).ready(function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#email").keypress(function() {
            var elem = $(this);

           // Save current value of element
           elem.data('oldVal', elem.val());

           // Look for changes in the value
           elem.bind("propertychange change click keyup input paste", function(event){
              // If value has changed...
              if (elem.data('oldVal') != elem.val()) {
               // Updated stored value
               elem.data('oldVal', elem.val());

               //$('.email-info').html(elem.data('oldVal'));
                
                $.ajax({

                    url: '/checkEmail/',
                    type: "POST",
                    data: {'email':elem.data('oldVal'), '_token': CSRF_TOKEN},
                    dataType: 'JSON',
                    success: function(data){
                        $('.email-info').html(data);
                    }
                }); 
             }
           });
        });
    });
    </script>
</head>
<body>
<div class="container">

@include('header.navbar_not_loggedin')

<h1>Register Admin</h1>

<!-- if there are creation errors, they will show here -->
<div class="alert alert-info">{!! Html::ul($errors->all()) !!}
@if (Session::has('_errors'))
    {{ Session::get('_errors') }}
@endif
</div>
{!! Form::open(array('url' => 'admin')) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', Input::old('name'), array('class' => 'form-control', 'placeholder' => ' Enter your name')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('email', 'Email') !!}
        {!! Form::email('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => ' Enter your email')) !!}
        <div class="email-info"></div>
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Password') !!}
        {!! Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password2', 'Confirm Password') !!}
        {!! Form::password('password2', array('class' => 'form-control', 'placeholder' => 'Confirm Password')) !!}
    </div>

    {!! Form::submit('Register!', array('class' => 'btn btn-primary')) !!}

{!! Form::close() !!}

</div>
</body>
</html>