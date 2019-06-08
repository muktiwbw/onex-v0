<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{route('admin-users')}}">Users</a></li>
            <li><a href="{{route('admin-exams')}}">Exams</a></li>
            <li><a href="{{route('logout')}}">Logout</a></li>
        </ul>
    </nav>
    <h1>Create Question {{$level->name}} Number {{$newNumber}}</h1>
    <form action="#">
        <div>
            <textarea name="body" cols="30" rows="10" placeholder="Fill the question body here!"></textarea>
        </div>
        <div><button id="switch">Switch Type</button></div>
    </form>

    <script>
        (function(){
            const switchButton = document.getElementById('switch')

            switchButton.addEventListener('click', function(e){
                e.preventDefault()
            })
        })()
    </script>
</body>
</html>