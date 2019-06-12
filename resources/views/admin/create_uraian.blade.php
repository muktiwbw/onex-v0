<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Create Uraian</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{route('admin-users')}}">Users</a></li>
            <li><a href="{{route('admin-exams')}}">Exams</a></li>
            <li><a href="{{route('logout')}}">Logout</a></li>
        </ul>
    </nav>
    <h1>Exams Page</h1>
    <h2>Level {{$level->name}}</h2>
    <div>
        <form action="{{route('admin-uraian-store')}}" method="post">
            <textarea name="editor" id="editor" cols="30" rows="10"></textarea>
            <input type="submit" value="Submit">
            @csrf
        </form>
    </div>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        const options = {
            
        };

        CKEDITOR.replace( 'editor', options );
    </script>
</body>
</html>