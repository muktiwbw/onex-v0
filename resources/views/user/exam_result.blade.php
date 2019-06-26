<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$answer_sheet->level->name}} - Hasil</title>
</head>
<body>
    <h1>{{$answer_sheet->level->name}} - Hasil</h1>
    <div id="profile">
        <p>Nama: {{$answer_sheet->user->name}}</p>
        <p>Mulai: {{$answer_sheet->created_at}}</p>
        @if($answer_sheet->report()->count() > 0)
        <p>Skor Total: {{$answer_sheet->report->score}}</p>
        <p>Skor Penilaian Diri: {{$answer_sheet->evaluation_answers()->where('answer', true)->count()}}</p>
        @endif
    </div>
    <div><a href="{{route('user')}}">Kembali</a> - <a href="{{route('user-exam-reset', ['level_id' => $answer_sheet->level->id])}}">Ulangi</a></div>
</body>
</html>