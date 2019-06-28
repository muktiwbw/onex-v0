@extends('admin.main')
@section('head')
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
@endsection

@section('content')
<h1 class="h3 mb-4 text-gray-800">
        Edit Studi Kasus
    </h1>
    <div class="row">
        <div class="col-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Level {{$caseStudy->level->name}}
                    </h6>
                </div>

                <div class="card-body">
                    <form action="{{route('admin-case-study-patch')}}" method="post" enctype="multipart/form-data">
                        <!-- <button id="type-switch">Ganti Audio</button> -->
                        <div class="text-right mb-0">
                            <button id="type-switch" class="btn btn-success btn-circle btn-sm text-white">@if($caseStudy->type == 'TEXT') <i class="fas fa-volume-up"></i> @else <i class="fas fa-align-left"></i> @endif</button>
                        </div>
                        <div class="form-group">
                            <label>Judul Studi Kasus</label>
                            <input class="form-control" type="text" name="cs_title" value="{{$caseStudy->title}}" placeholder="Tuliskan judul studi kasus">
                        </div>
                        <div id="cs-body">
                            <textarea name="cs_body" cols="30" rows="10">@if($caseStudy->type == 'TEXT') {{$caseStudy->body}} @endif</textarea>
                        </div>
                        <div id="cs-audio" class="form-group">
                            <div class="form-group">
                                <label>Upload Rekaman</label>
                                <input type="file" class="form-control-file" name="cs_audio">
                            </div>
                        </div>
                        <input id="cs-type" type="hidden" name="cs_type" value="{{$caseStudy->type}}">
                        <input type="hidden" name="case_study_id" value="{{$caseStudy->id}}">
                        <input type="hidden" name="level_id" value="{{$caseStudy->level->id}}">
                        <input type="submit" class="btn btn-primary mt-3" value="Simpan">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
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
                this.innerHTML = '<i class="fas fa-align-left"></i>'
                csBody.style.display = 'none'
                csAudio.style.display = 'block'
            }else{
                csType.value = 'TEXT'
                this.setAttribute('type', 'text')
                this.innerHTML = '<i class="fas fa-volume-up"></i>'
                csAudio.style.display = 'none'
                csBody.style.display = 'block'
            }
        })
    </script>
@endsection