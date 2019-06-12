<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <style>
        #question-audio, #answer-essay{
            display: none;
        }
    </style>
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>Create Question {{$level->name}}</h1>
    <form action="{{route('admin-question-store')}}" method="POST" enctype="multipart/form-data">
        <div id="case-study-section">
            Studi kasus: 
            <select name="case_study">
                <option value="0">Tidak ada</option>
                @foreach($caseStudies as $caseStudy)
                <option value="{{$caseStudy->id}}">{{$caseStudy->level->name}} - {{$caseStudy->number}}. {{$caseStudy->title}}</option>
                @endforeach
            </select>
            <a href="{{route('admin-case-study-create', ['level_id' => $level->id])}}">Buat Studi Kasus</a>
        </div>
        <div id="question-section">
            <textarea id="question-text" name="body" cols="30" rows="10" placeholder="Fill the question body here!"></textarea>
        </div>
        <div>
            <select name="answer-type-identifier" id="answer-type-dropdown">
                <option value="MULTIPLE" selected>Multiple Choice</option>
                <option value="ESSAY">Essay</option>
                <option value="CHECKLIST">Checklist</option>
            </select>
        </div>
        <div id="answer-section">
            <textarea name="essay" id="answer-essay" cols="30" rows="10" placeholder="Fill the answer for essay here!"></textarea>
            <div id="answer-multiple">
                @php
                $point = 'a';
                @endphp
                @for($i=0;$i<4;$i++)
                <div> <input type="radio" name="correct" value="{{$i}}" @if($point == 'a') checked @endif> {{$point}} <textarea name="multi[]" cols="30" rows="1"></textarea></div>
                @php
                $point++;
                @endphp
                @endfor
            </div>
        </div>
        <input type="hidden" name="level_id" value="{{$level->id}}">
        @csrf
        <input type="submit" value="Submit">
    </form>
        
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        (function(){

            const switchQuestionButton = document.getElementById('switch-question')
            const switchAnswerButton = document.getElementById('switch-answer')
            const answerEssay = document.getElementById('answer-essay')
            const answerMultiple = document.getElementById('answer-multiple')
            const answerTypeIdentifier = document.getElementById('answer-type-identifier')

            const questionBody = document.getElementById('question-text')

            switchAnswerButton.addEventListener('click', function(e){
                e.preventDefault()
                if(answerTypeIdentifier.value == 'multiple'){
                    answerTypeIdentifier.value = 'essay'
                    answerMultiple.style.display = 'none'
                    answerEssay.style.display = 'block'
                }else{
                    answerTypeIdentifier.value = 'multiple'
                    answerEssay.style.display = 'none'
                    answerMultiple.style.display = 'block'
                }
            })

            CKEDITOR.replace( questionBody );
        })()
    </script>
</body>
</html>