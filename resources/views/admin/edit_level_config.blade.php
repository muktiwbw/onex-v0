<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pengaturan Level {{$level->name}}</title>
</head>
<body>
    <h1>Pengaturan Level {{$level->name}}</h1>
    <form action="{{route('admin-level-config-patch')}}" method="post">
        <p>Minimum nilai ujian: <input type="number" name="exam" value="{{$level->exam_threshold}}"></p>
        <p>Minimum nilai penilaian diri: <input type="number" name="evaluation" value="{{$level->evaluation_threshold}}"></p>
        <input type="hidden" name="level_id" value="{{$level->id}}">
        <input type="submit" value="Simpan">
        @csrf
    </form>
</body>
</html>