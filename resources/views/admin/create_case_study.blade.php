<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Create Tujuan Pembelajaran</title>
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>Buat Studi Kasus</h1>
    <h2>Level {{$level->name}}</h2>
    <div>
        <form action="{{route('admin-case-study-store')}}" method="post">
            <input type="text" name="title" placeholder="Tuliskan judul studi kasus">
            <textarea name="editor" id="editor" cols="30" rows="10"></textarea>
            <input type="submit" value="Submit">
            <input type="hidden" name="level_id" value="{{$level->id}}">
            @csrf
        </form>
    </div>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'editor' );
    </script>
</body>
</html>