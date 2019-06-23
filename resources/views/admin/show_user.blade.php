<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User - {{$user->name}}</title>
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>User - {{$user->name}}</h1>
    <h2>Level yang sudah dikerjakan</h2>
    <div>
        @php $id = $user->id; @endphp
        @foreach($answer_sheets as $answer_sheet)
        <p><a href="{{route('admin-user-result', ['user_id' => $user->id, 'level_id' => $answer_sheet->level->id])}}">Level {{$answer_sheet->level->name}}</a></p>
        @endforeach
    </div>
</body>
</html>