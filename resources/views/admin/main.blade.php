<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>Admin Page</h1>
    <h2>Welcome, {{$user->name}}!</h2>
</body>
</html>