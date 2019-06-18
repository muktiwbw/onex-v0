<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$question->level->name}} - Number {{$question->number}}</title>
</head>
<body>  
    @component('components.navbar')@endcomponent
    <h1>{{$question->level->name}} - Number {{$question->number}}</h1>
    @if($question->case_study)
    <div id="case-study-section">
        <h2><a href="{{route('admin-case-study', ['case_study_id' => $question->case_study->id])}}">Case Study: {{$question->case_study->title}}</a></h2>
    </div>
    @endif
    <div id="question-section">
        <h3>Soal:</h3>
        {!!$question->body!!}
    </div>
    <div id="answer-section">
        <h3>Jawaban:</h3>
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
    <div><a href="{{route('admin-question-edit', ['question_id' => $question->id])}}">Edit Soal</a> - <a href="{{route('admin-question-remove', ['question_id' => $question->id])}}">Remove Soal</a></div>
</body>
</html>