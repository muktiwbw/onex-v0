<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exam - {{$question->level->name}}</title>
</head>
<body>
    <!-- $question->case_study gawe ngetokno studi kasus'e soal tsb -->
    @if($question->case_study()->count() > 0)
    <div id="case-study-section">
    <h2>Studi Kasus {{$question->case_study->number}}</h2>
    {!!$question->case_study->body!!}
    </div>
    @endif
    <div id="number-section">{{$question->level->name}} - {{$question->number}}</div>
    <div id="question-section">{!!$question->body!!}</div>
    <div id="answer-section">
        <form action="{{route('user-exam-answer-store')}}" method="post">
            @switch($question->answer_type)
                @case('MULTIPLE')
                    <div id="answer-multiple">
                        @foreach($question->choices()->orderBy('point', 'asc')->get() as $choice)
                        <p><input type="radio" name="mc_answer" id="" value="{{$choice->point}}" @if(($answer != null && $answer->point == $choice->point) || ($answer == null && $choice->point == 'a')) checked @endif>{{$choice->point}}. {{$choice->body}}</p>
                        @endforeach
                    </div>
                    @break

                @case('ESSAY')
                    <div id="answer-essay">
                        <textarea name="essay" id="" cols="30" rows="10">@if($answer != null) {{$answer->essay}} @endif</textarea>
                    </div>
                    @break

                @case('CHECKLIST')
                    <div id="answer-checklist">
                        @php if($answer != null) $cl_answers = json_decode($answer->checklists); @endphp
                        @foreach($question->checklists()->orderBy('id', 'asc')->get() as $checklist)
                        <p>{{$checklist->body}} ==============> @for($i=0; $i<5; $i++) ({{$i+1}} <input type="radio" name="cl_answer[{{$loop->index}}]" id="" value="{{$i+1}}" @if(($answer != null && $cl_answers[$loop->index] == $i+1) || ($answer == null && $i == 0)) checked @endif>) @endfor</p>
                        @endforeach
                    </div>
                    @break
            @endswitch
            <input type="submit" value="Submit">
            <input type="hidden" name="question_id" value="{{$question->id}}">
            @csrf
        </form>
    </div>
    @if($question->level->case_studies()->has('questions')->count() > 0)
    <div id="cs-number">
        @foreach($question->level->case_studies()->has('questions')->orderBy('number', 'asc')->get() as $cs)
        <div>
            Studi Kasus {{$cs->number}}
            <p>
                @foreach($cs->questions()->orderBy('number', 'asc')->get() as $qst)
                <a href="{{route('user-exam-questions', ['level_id' => $qst->level->id, 'case_study_number' => $qst->case_study->number, 'question_number' => $qst->number])}}">{{$qst->number}}</a> @if(!$loop->last) - @endif
                @endforeach
            </p>
        </div>
        @endforeach
    </div>
    @endif
    <div id="non-cs-number">
        @foreach($question->level->questions()->doesnthave('case_study')->orderBy('number', 'asc')->get() as $q)
        <a href="{{route('user-exam-questions', ['level_id' => $q->level->id, 'case_study_number' => 0, 'question_number' => $q->number])}}">{{$q->number}}</a> @if(!$loop->last) - @endif
        @endforeach
    </div>
    <div id="finish">
        <a href="{{route('user-exam-finish', ['level' => $question->level->id])}}">Selesai</a>
    </div>
</body>
</html>