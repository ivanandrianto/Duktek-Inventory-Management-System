<!-- app/views/nerds/show.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Look! I'm CRUDding</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

@include('header.navbar_loggedin')

<h1>Showing {{ $booking->name }}</h1>

    <div class="jumbotron text-center">
        <h2>{{ $booking->name }}</h2>
        <p>
            <h1> {{ $booking->title }}</h1>
            <strong>Content:</strong> {{ $booking->content }}<br>
            <strong>Excerpt:</strong> {{ $booking->excerpt }}<br>
        </p>
    </div>

</div>
</body>
</html>