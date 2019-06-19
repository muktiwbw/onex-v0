<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Buat Studi Kasus</title>
    <style>
        #cs-audio{
            display: none;
        }
    </style>
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>Buat Studi Kasus</h1>
    <h2>Level {{$level->name}}</h2>
    <div>
        <form action="{{route('admin-case-study-store')}}" method="post" enctype="multipart/form-data">
            <input type="text" name="cs_title" placeholder="Tuliskan judul studi kasus"> <button id="type-switch">Ganti Audio</button>
            <div id="cs-body">
                <textarea name="cs_body" cols="30" rows="10"></textarea>
            </div>
            <div id="cs-audio">
                <input type="file" name="cs_audio">
            </div>
            <input type="submit" value="Submit">
            <input id="cs-type" type="hidden" name="cs_type" value="TEXT">
            <input type="hidden" name="level_id" value="{{$level->id}}">
            @csrf
        </form>
    </div>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        const csBody = document.getElementById('cs-body');
        const csAudio = document.getElementById('cs-audio');
        const csType = document.getElementById('cs-type');
        const typeSwitch = document.getElementById('type-switch');
        const options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
        
        CKEDITOR.replace( 'cs_body', options );

        typeSwitch.addEventListener('click', function(e){
            e.preventDefault()
            e.stopPropagation()

            if(csType.value == 'TEXT'){
                csType.value = 'AUDIO'
                this.setAttribute('type', 'audio')
                this.innerHTML = 'Ganti ke Text'
                csBody.style.display = 'none'
                csAudio.style.display = 'block'
            }else{
                csType.value = 'TEXT'
                this.setAttribute('type', 'text')
                this.innerHTML = 'Ganti ke Audio'
                csAudio.style.display = 'none'
                csBody.style.display = 'block'
            }
        })
    </script>
</body>
</html>