<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit {{$question->level->name}} - Number {{$question->number}}</title>
</head>
<body>
    <h1>Edit {{$question->level->name}} - Number {{$question->number}}</h1>
    <form action="#" method="post">
        <div id="question-section">
            @if(substr($question->body,0,11) == 'files/audio')
            <!-- Show media with path $question->body--> <p>{{$question->body}}</p>
            @else
            <textarea name="question_body" id="" cols="30" rows="10">{{$question->body}}</textarea>
            @endif
        </div>
        <div id="answer-section">
            @if($question->type == 'ESSAY')
            <textarea name="essay-body" id="" cols="30" rows="10">{{$question->essay}}</textarea>
            @else
            @foreach($question->choices as $choice)
            <div><input type="radio" name="correct" @if($choice->correct) checked @endif> {{$choice->point}} - <textarea name="multi[]" cols="30" rows="1">{{$choice->body}}</textarea></div>
            @endforeach
            @endif
        </div>
        <div><input type="submit" value="Submit"></div>
    </form>
</body>
</html>