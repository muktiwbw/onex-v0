<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Users List</title>
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>Users List Page</h1>
    <ul>
        @foreach($users as $user)
        <li>{{$user->name}} - {{$user->privilege->type}} @if($user->privilege->type == 'USER')<a href="{{route('admin-user-show', ['user_id' => $user->id])}}">Lihat progress</a> @endif</li>
        @endforeach
    </ul>
</body>
</html>