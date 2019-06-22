<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$level->name}} - Penilaian Diri</title>
</head>
<body>
    <h1>{{$level->name}} - Penilaian Diri</h1>
    <form action="{{route('user-exam-evaluation-store')}}" method="post">
        @foreach($level->evaluations()->orderBy('number', 'asc')->get() as $eval)
        <p>{{$eval->body}} ===============> <input type="radio" name="eval[{{$loop->index}}]" value=1>Ya - <input type="radio" name="eval[{{$loop->index}}]" value=0 checked>Tidak</p>
        @endforeach
        <input type="hidden" name="level_id" value="{{$level->id}}">
        <input type="submit" value="Submit">
        @csrf
    </form>
</body>
</html>