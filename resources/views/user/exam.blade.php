@extends('user.main_exam')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">
        {{$question->level->name}}
    </h1>
    @if($question->case_study()->count() > 0)
        <div class="row">
            <div class="col-md-12" id="case-study-section">
                <!-- Collapsable Card Example -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#study{{$question->case_study->id}}" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="study{{$question->case_study->id}}">
                        <h6 class="m-0 font-weight-bold text-primary">Studi Kasus - {{$question->case_study->number}}</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="study{{$question->case_study->id}}">
                        <div class="card-body">
                            @if($question->case_study->type == 'TEXT')
                                {!!$question->case_study->body!!}
                            @else
                                <audio controls>
                                    <source src="{{ URL::to('/') }}/files/{!!$question->case_study->body!!}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12" id="case-study-section">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Soal {{$question->number}}
                    </h6>
                </div>
                <div class="card-body">

                    {!!$question->body!!}
                    
                    <br><br>
                    <label>Jawaban :</label>
                    <form action="{{route('user-exam-answer-store')}}" method="post">
                        @switch($question->answer_type)
                            @case('MULTIPLE')
                                @foreach($question->choices()->orderBy('point', 'asc')->get() as $choice)
                                    <div class="custom-control custom-checkbox ">
                                        <input type="radio" id="pg{{$choice->point}}" name="mc_answer" class="custom-control-input" value="{{$choice->point}}" @if($answer != null && $answer->point == $choice->point) checked @endif>
                                        <label class="custom-control-label" for="pg{{$choice->point}}">{{$choice->point}}. {{$choice->body}}</label>
                                    </div>
                                @endforeach
                               
                                @break
                
                            @case('ESSAY')
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" name="essay">@if($answer != null) {{$answer->essay}} @endif</textarea>
                                </div>
                                @break
                
                            @case('CHECKLIST')
                                @php if($answer != null) $cl_answers = json_decode($answer->checklists); @endphp
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kompetensi</th>
                                                <th scope="col" class="text-center">1</th>
                                                <th scope="col" class="text-center">2</th>
                                                <th scope="col" class="text-center">3</th>
                                                <th scope="col" class="text-center">4</th>
                                                <th scope="col" class="text-center">5</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($question->checklists()->orderBy('id', 'asc')->get() as $checklist)
                                                <tr>
                                                    <th scope="row">{{$checklist->body}}</th>
                                                    @for($i = 0; $i < 5; $i++)
                                                        <td class="text-center">
                                                            <div class="custom-control custom-checkbox ">
                                                                <input type="radio" id="{{$checklist->body}}_{{$i}}" name="cl_answer[{{$loop->index}}]" class="custom-control-input" value="{{$i+1}}" @if(($answer != null && $cl_answers[$loop->index] == $i+1)) checked @endif>
                                                                <label class="custom-control-label" for="{{$checklist->body}}_{{$i}}"></label>
                                                            </div>
                                                        </td>
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @break
                        @endswitch
                        <div class="text-right">
                            <input type="submit" class="btn btn-primary" value="Simpan">
                            <a class="btn btn-success" href="{{route('user-exam-finish', ['level' => $question->level->id])}}">Selesai</a>
                        </div>
                        <input type="hidden" name="question_id" value="{{$question->id}}">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection