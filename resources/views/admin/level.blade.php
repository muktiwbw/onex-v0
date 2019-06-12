<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{route('admin-users')}}">Users</a></li>
            <li><a href="{{route('admin-exams')}}">Exams</a></li>
            <li><a href="{{route('logout')}}">Logout</a></li>
        </ul>
    </nav>
    <h1>Exams Page</h1>
    <h2>Level {{$level->name}}</h2>
    <div><a href="{{route('admin-uraian-create', ['level_id' => $level->id])}}">Add Uraian Materi</a></div>
    <div>
        @foreach($level->questions as $question)
        <p><a href="{{route('admin-exams', ['level_id' => $question->level->id, 'question_id' => $question->id])}}">{{$question->number}}.) {{substr($question->body,0,11) == 'files/audio' ? 'AUDIO' : 'TEXT'}} - {{$question->type}}</a></p>
        <!-- pake question $question->body untuk nampilin pertanyaannya -->
        @endforeach
    </div>
    <div><a href="{{route('admin-exams', ['level_id' => $level->id, 'question_id' => 'question', 'do' => 'create'])}}">Add Soal</a></div>
</body>
</html>