@extends('admin.main')
@section('content')
    @if($level->case_studies()->count() > 0 && $level->case_studies()->whereHas('questions', function($question){
        $question->where('answer_type', 'ESSAY');
    })->count() > 0)
        <form action="{{route('admin-user-essay-submit')}}" method="post">
            @foreach($level->case_studies()->whereHas('questions', function($question){
                $question->where('answer_type', 'ESSAY');
            })->orderBy('number', 'asc')->get() as $case_study)
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Studi Kasus {{$case_study->number}} - {{$case_study->title}}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            {!!$case_study->body!!}
                                        </div>
                                    </div>
                                    @foreach($case_study->questions()->where('answer_type', 'ESSAY')->orderBy('number', 'asc')->get() as $question)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card shadow mb-4">
                                                <div class="card-header py-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">{{$question->level->name}} - Studi Kasus {{$question->case_study->number}} - No. {{$question->number}}</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="m-0 font-weight-bold text-danger">Soal</h6>
                                                            <span>{!!$question->body!!}</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="m-0 font-weight-bold text-success">Jawaban</h6>
                                                            <p>{{$question->essay}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            Score: <input type="number" name="score[]" min="0" max="{{$question->score}}" value="{{$question->score}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="row">
                <div class="col-md-12">
                    <input class="btn btn-primary btn-block" type="submit" value="Submit">
                </div>
            </div>
            <input type="hidden" name="answer_sheet_id" value="{{$answer_sheet->id}}"> 
            @csrf
        </form>
    @endif
@endsection