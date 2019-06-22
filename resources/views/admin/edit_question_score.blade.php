<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$level->name}} - Edit Skor Soal</title>
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>Level {{$level->name}}</h1>
    <form action="{{route('admin-question-score-patch')}}" method="post">
        @if($level->case_studies()->has('questions')->count() > 0)
        <div id="cs-question">
            @foreach($level->case_studies()->has('questions')->orderBy('number', 'asc')->get() as $cs)
            <h2><a href="{{route('admin-case-study', ['case_study_id' => $cs->id])}}">Studi Kasus {{$cs->number}}: {{$cs->title}}</a></h2>
                @foreach($cs->questions()->orderBy('number', 'asc')->get() as $question)
                <p>{{$question->number}}. {{$question->answer_type}} <input type="number" name="question[]" value="{{$question->score}}"></p>
                @endforeach
            @endforeach    
        </div>
        @endif
        @if($level->questions()->doesnthave('case_study')->count() > 0)
        <div id="question">
            @foreach($level->questions()->doesnthave('case_study')->orderBy('number', 'asc')->get() as $question)
            <p>{{$question->number}}. {{$question->answer_type}} <input type="number" name="question[]" value="{{$question->score}}"></p>
            @endforeach
        </div>
        @endif
        <p>*) Skor tipe soal checklist merupakan skor individual tiap poin checklist</p>
        <input type="hidden" name="level_id" value="{{$level->id}}">
        <input type="submit" value="Submit">
        @csrf
    </form>
</body>
</html>