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
    <form action="{{route('admin-question-patch')}}" method="post">
        <div id="case-study-section">
            <select name="case_study">
                <option value="0">Tidak ada</option>
                @foreach($question->level->case_studies as $case_study)
                <option value="{{$case_study->id}}" @if($question->case_study) @if($question->case_study->id == $case_study->id) selected @endif @endif>{{$case_study->title}}</option>
                @endforeach
            </select>
        </div>
        <div id="question-section">
            <div>
                <textarea name="question_body" id="question-body" cols="30" rows="10">{!!$question->body!!}</textarea>
            </div>
        </div>
        <div id="answer-section">
            @switch($question->answer_type)
                @case('MULTIPLE')
                    <div>
                        @foreach($question->choices as $key => $choice)
                        <p><input type="radio" name="answer_correct" value="{{$key}}" @if($choice->correct) checked @endif> <textarea name="multi[]" cols="30" rows="1">{{$choice->body}}</textarea></p>
                        @endforeach
                    </div>
                    @break
                    
                @case('ESSAY')
                    <div>
                        <textarea name="essay" cols="30" rows="10">{{$question->essay}}</textarea>
                    </div>
                    @break

                @case('CHECKLIST')
                    <div>
                        @foreach($question->checklists()->orderBy('id', 'asc')->get() as $checklist)
                        <p><textarea name="cl_body" cols="30" rows="1">{{$checklist->body}}</textarea><input type="number" name="cl_correct" min="1" max="5" value="{{$checklist->answer}}"></p>
                        @endforeach
                    </div>
                    @break
            @endswitch
        </div>
        <input type="hidden" name="question_id" value="{{$question->id}}">
        @csrf
        <div><input type="submit" value="Submit"></div>
    </form>
    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        const questionBody = document.getElementById('question-body')

        CKEDITOR.replace( questionBody );
    </script>
</body>
</html>