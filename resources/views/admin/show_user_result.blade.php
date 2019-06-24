<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$answer_sheet->level->name}} - Hasil</title>
</head>
<body>
    @component('components.navbar')@endcomponent    
    <h1>{{$answer_sheet->user->name}}</h1>
    <h2>{{$answer_sheet->level->name}} - Hasil</h2>
    <div id="profile">
        <p>Nama: {{$answer_sheet->user->name}}</p>
        <p>Mulai: {{$answer_sheet->created_at}}</p>
        <p>Skor Total (Multiple choice & Checklist): {{$total_score}}</p>
    </div>
</body>
</html>