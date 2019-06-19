<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$user->name}} - Profile</title>
</head>
<body>
    <h1>Welcome, {{$user->name}}!</h1>
    <h2>Daftar Test</h2>
    <ul>
        @foreach($levels as $level)
        <li><a href="#">{{$level->name}}</a></li>
        @endforeach
    </ul>
</body>
</html>