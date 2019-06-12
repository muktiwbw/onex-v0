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
    <h2>Daftar Soal</h2>
    <div>
        @foreach($level->questions as $question)
        <p><a href="{{route('admin-exams', ['level_id' => $question->level->id, 'question_id' => $question->id])}}">{{$question->number}}.) {{substr($question->body,0,11) == 'files/audio' ? 'AUDIO' : 'TEXT'}} - {{$question->type}}</a></p>
        <!-- pake question $question->body untuk nampilin pertanyaannya -->
        @endforeach
    </div>
    <div><a href="{{route('admin-question-create', ['level_id' => $level->id])}}">Add Soal</a></div>
</body>
</html>