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
    <h1>Buat Tujuan Pembelajaran</h1>
    <h2>Level {{$level->name}}</h2>
    <div>
        <form action="{{route('admin-tujuan-store')}}" method="post">
            <textarea name="editor" id="editor" cols="30" rows="10">{{$level->tujuan}}</textarea>
            <input type="submit" value="Submit">
            <input type="hidden" name="level_id" value="{{$level->id}}">
            @csrf
        </form>
    </div>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        const options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
        CKEDITOR.replace( 'editor', options );
    </script>
</body>
</html>