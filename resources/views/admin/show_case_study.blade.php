<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Case Study {{$caseStudy->title}}</title>
</head>
<body>
    @component('components.navbar')@endcomponent
    <div id="case-study-section">
        <h1>{{$caseStudy->number}}. {{$caseStudy->title}}</h1>
        {!!$caseStudy->body!!}
        <div><a href="{{route('admin-case-study-edit', ['case_study_id' => $caseStudy->id])}}">Edit</a> - <a href="{{route('admin-case-study-remove', ['case_study_id' => $caseStudy->id])}}">Delete</a></div>
    </div>
    <div id="question-section">
        @foreach($caseStudy->questions as $question)
        <div>
            <h2><a href="{{route('admin-question', ['question_id' => $question->id])}}">Question {{$question->number}} - {{$question->answer_type}}</a></h2> 
            {!!$question->body!!}
            <h3>Answer:</h3>
            @switch($question->answer_type)
                @case('MULTIPLE')
                    @foreach($question->choices()->orderBy('point', 'asc')->get() as $choice)
                    <p @if($choice->correct) style="font-wight:bold;color:green;" @endif>{{$choice->point}}. {{$choice->body}}</p>
                    @endforeach
                    @break
                    
                @case('ESSAY')
                    <p>{{$question->essay}}</p>
                    @break

                @case('CHECKLIST')
                    <ul>
                        @foreach($question->checklists()->orderBy('id', 'asc')->get() as $checklist)
                        <li>{{$checklist->body}}: {{$checklist->answer}}</li>
                        @endforeach
                    </ul>
                    @break
            @endswitch
        </div>
        @endforeach
    </div>
</body>
</html>