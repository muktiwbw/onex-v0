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
    <nav>
        <ul>
            <li><a href="{{route('admin-users')}}">Users</a></li>
            <li><a href="{{route('admin-exams')}}">Exams</a></li>
            <li><a href="{{route('logout')}}">Logout</a></li>
        </ul>
    </nav>
    <h1>Create Question {{$level->name}} Number {{$newNumber}}</h1>
    <form action="{{route('admin-exams-create', ['level_id' => $level->id])}}" method="POST" enctype="multipart/form-data">
        <div id="question-section">
            <textarea id="question-text" name="body" cols="30" rows="10" placeholder="Fill the question body here!"></textarea>
            <input type="file" name="audio" id="question-audio">
        </div>
        <div><button id="switch-question">Switch Question Type</button></div>
        <div id="answer-section">
            <textarea name="essay" id="answer-essay" cols="30" rows="10" placeholder="Fill the answer for essay here!"></textarea>
            <div id="answer-multiple">
                @php
                $point = 'a';
                @endphp
                @for($i=0;$i<5;$i++)
                <div> <input type="radio" name="correct" value="{{$i}}" @if($point == 'a') checked @endif> {{$point}} <textarea name="multi[]" cols="30" rows="1"></textarea></div>
                @php
                $point++;
                @endphp
                @endfor
            </div>
        </div>
        <div><button id="switch-answer">Switch Answer Type</button></div>
        <input id="question-type-identifier" type="hidden" name="question_type" value="text">
        <input id="answer-type-identifier" type="hidden" name="answer_type" value="multiple">
        <input type="hidden" name="number" value="{{$newNumber}}">
        <input type="hidden" name="level_id" value="{{$level->id}}">
        @csrf
        <input type="submit" value="Submit">
    </form>

    <script>
        (function(){
            const switchQuestionButton = document.getElementById('switch-question')
            const switchAnswerButton = document.getElementById('switch-answer')
            const questionAudio = document.getElementById('question-audio')
            const questionText = document.getElementById('question-text')
            const answerEssay = document.getElementById('answer-essay')
            const answerMultiple = document.getElementById('answer-multiple')
            const questionTypeIdentifier = document.getElementById('question-type-identifier')
            const answerTypeIdentifier = document.getElementById('answer-type-identifier')

            switchQuestionButton.addEventListener('click', function(e){
                e.preventDefault()
                if(questionTypeIdentifier.value == 'text'){
                    questionTypeIdentifier.value = 'file'
                    questionText.style.display = 'none'
                    questionAudio.style.display = 'block'
                }else{
                    questionTypeIdentifier.value = 'text'
                    questionAudio.style.display = 'none'
                    questionText.style.display = 'block'
                }
                
            })
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
        })()
    </script>
</body>
</html>