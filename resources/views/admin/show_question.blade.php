<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$question->level->name}} - Number {{$question->number}}</title>
</head>
<body>
    <h1>{{$question->level->name}} - Number {{$question->number}}</h1>
    <div id="question-section">
        @if(substr($question->body,0,11) == 'files/audio')
        <!-- Show media with path $question->body--> <p>{{$question->body}}</p>
        @else
        <p>{{$question->body}}</p>
        @endif
    </div>
    <div id="answer-section">
        @if($question->type == 'ESSAY')
        <p>{{$question->essay}}</p>
        @else
        @foreach($question->choices as $choice)
        <p @if($choice->correct) style="font-weight:bold;color:green" @endif>{{$choice->point}}.) {{$choice->body}}</p>
        @endforeach
        @endif
    </div>
    <div><a href="{{route('admin-exams', ['level_id' => $question->level->id, 'question_id' => $question->id, 'do' => 'edit'])}}">Edit Soal</a></div>
</body>
</html>