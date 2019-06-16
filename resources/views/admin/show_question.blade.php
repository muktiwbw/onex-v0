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
        {!!$question->body!!}
    </div>
    <div id="answer-section">
        @switch($question->answer_type)
            @case('MULTIPLE')
                @foreach($question->choices as $choice)
                <p @if($choice->correct) style="font-weight:bold;color:green" @endif>{{$choice->point}}.) {{$choice->body}}</p>
                @endforeach
                @break
            
            @case('ESSAY')
                <p>{{$question->essay}}</p>
                @break

            @case('CHECKLIST')
                @foreach($question->checklists as $checklist)
                <p>{{$checklist->body}} - @if($checklist->answer){{$checklist->answer}}@else NONE @endif</p>
                @endforeach
                @break
        @endswitch
    </div>
    <div><a href="{{route('admin-exams', ['level_id' => $question->level->id, 'question_id' => $question->id, 'do' => 'edit'])}}">Edit Soal</a></div>
</body>
</html>