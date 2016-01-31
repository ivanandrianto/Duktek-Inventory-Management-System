<!DOCTYPE html>
<html>
<head>
    <title>Look! I'm CRUDding</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('gila') }}">Gila Alert</a>
    </div>
    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('gila') }}">View All Gila</a></li>
        <li><a href="{{ URL::to('gila/create') }}">Create a Gila</a>
    </ul>
</nav>

<h1>All the Gila</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Email</td>
            <td>Gila Level</td>
            <td>Actions</td>
        </tr>
    </thead>
    <tbody>
    @foreach($gila as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->email }}</td>
            <td>{{ $value->gila_level }}</td>

            <!-- we will also add show, edit, and delete buttons -->
            <td>

                <!-- delete the gila (uses the destroy method DESTROY /gila/{id} -->
                <!-- we will add this later since its a little more complicated than the other two buttons -->

                <!-- show the gila (uses the show method found at GET /gila/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('gila/' . $value->id) }}">Show this Gila</a>

                <!-- edit this gila (uses the edit method found at GET /gila/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('gila/' . $value->id . '/edit') }}">Edit this Gila</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>ID</td>
            <td>Title</td>
            <td>Content</td>
        </tr>
    </thead>
    <tbody>
    @foreach($gila2 as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->title }}</td>
            <td>{{ $value->content }}</td>
            <td>{{ $value->content }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
</body>
</html>