<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>Level {{$level->name}}</h1>
    <h2>Pengaturan Level {{$level->name}}</h2>
    <p><a href="{{route('admin-level-config', ['level_id' => $level->id])}}">Edit Pengaturan</a></p>
    <h2>Tujuan Pembelajaran</h2>
    @if($level->tujuan == null)
    <div><a href="{{route('admin-tujuan-create', ['level_id' => $level->id])}}">Add Tujuan Pembelajaran</a></div>
    @else
    {!!$level->tujuan!!}
    <div><a href="{{route('admin-tujuan-create', ['level_id' => $level->id])}}">Edit Tujuan Pembelajaran</a></div>
    @endif
    <h2>Uraian Materi</h2>
    @if($level->uraian == null)
    <div><a href="{{route('admin-uraian-create', ['level_id' => $level->id])}}">Add Uraian Materi</a></div>
    @else
    {!!$level->uraian!!}
    <div><a href="{{route('admin-uraian-create', ['level_id' => $level->id])}}">Edit Uraian Materi</a></div>
    @endif
    <h2>Penilaian Diri</h2>
    @if($level->evaluations()->count() > 0)
    <div>
        <ul>
            @foreach($level->evaluations()->orderBy('number', 'asc')->get() as $eval)
            <li>{{$eval->number}}. {{$eval->body}} - <a href="{{route('admin-evaluation-remove', ['evaluation_id' => $eval->id])}}">Delete</a></li>
            @endforeach
        </ul>
    </div>
    @endif
    <div>
        <a href="{{route('admin-evaluation-create', ['level_id' => $level->id])}}">Add Penilaian Diri</a> - <a href="{{route('admin-evaluation-edit', ['level_id' => $level->id])}}">Edit Penilaian Diri</a>
    </div>
    <h2>Daftar Soal</h2>
    <p><a href="{{route('admin-question-score-edit', ['level_id' => $level->id])}}">Edit Skor Soal</a></p>
    <div>
        @foreach($level->case_studies()->has('questions')->get() as $case_study)
        <h3><a href="{{route('admin-case-study', ['case_study_id' => $case_study->id])}}">Studi Kasus {{$case_study->number}} - {{$case_study->title}}</a></h3>
        <ul>
            @foreach($case_study->questions()->orderBy('number', 'asc')->get() as $question)
            <li><a href="{{route('admin-question', ['question_id' => $question->id])}}">{{$question->number}}. {{$question->answer_type}}</a></li>
            @endforeach
        </ul>
        @endforeach
        @if($level->questions()->doesnthave('case_study')->count() > 0)
        <h3>Soal Tanpa Studi Kasus</h3>
        @foreach($level->questions()->doesnthave('case_study')->orderBy('number', 'asc')->get() as $question)
        <p><a href="{{route('admin-question', ['question_id' => $question->id])}}">{{$question->number}}. {{$question->answer_type}}</a></p>
        @endforeach
        @endif
    </div>
    <div><a href="{{route('admin-question-create', ['level_id' => $level->id])}}">Add Soal</a></div>
</body>
</html>