<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Edit Studi Kasus</title>
    @if($caseStudy->type == 'TEXT')
    <style>
        #cs-audio{
            display: none;
        }
    </style>
    @else
    <style>
        #cs-body{
            display: none;
        }
    </style>
    @endif
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>Edit Studi Kasus</h1>
    <h2>{{$caseStudy->level->name}}</h2>
    <div>
        <form action="{{route('admin-case-study-patch')}}" method="post" enctype="multipart/form-data">
            <input type="text" name="cs_title" value="{{$caseStudy->title}}" placeholder="Tuliskan judul studi kasus"> <button id="type-switch">Ganti ke @if($caseStudy->type == 'TEXT') Audio @else Text @endif</button>
            <div id="cs-body">
                <textarea name="cs_body" cols="30" rows="10">@if($caseStudy->type == 'TEXT') {{$caseStudy->body}} @endif</textarea>
            </div>
            <div id="cs-audio">
                <input type="file" name="cs_audio">
            </div>
            <input type="submit" value="Submit">
            <input id="cs-type" type="hidden" name="cs_type" value="{{$caseStudy->type}}">
            <input type="hidden" name="case_study_id" value="{{$caseStudy->id}}">
            <input type="hidden" name="level_id" value="{{$caseStudy->level->id}}">
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