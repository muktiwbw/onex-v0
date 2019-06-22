<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Penilaian Diri - {{$level->name}}</title>
</head>
<body>
    @component('components.navbar')@endcomponent
    <h1>Edit Evaluation - {{$level->name}}</h1>
    <div>
        <form action="{{route('admin-evaluation-patch')}}" method="post">
            <div id="section-body">
                @foreach($level->evaluations()->orderBy('number', 'asc')->get() as $eval)
                <div>
                    <textarea name="evaluation[]" cols="30" rows="1">{{$eval->body}}</textarea>
                </div>
                @endforeach
            </div>
            <div>
                <input type="submit" value="Submit">
            </div>
            <input type="hidden" name="level_id" value="{{$level->id}}">
            @csrf
        </form>
    </div>
</body>
</html>