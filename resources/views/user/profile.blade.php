@extends('user.main')
@section('content')
    <div class="row">
        @foreach($levels as $level)
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><a href="{{route('user-exam-questions', ['level_id' => $level->id])}}">{{$level->name}}</a></h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <span style="font-size:84px"></span>
                        </div>
                        <div class="col-md-12">
                            <p>{{$level->case_studies()->has('questions')->count()}} studi kasus</p>
                            <p>{{$level->questions()->count()}} soal ({{$level->questions()->where('answer_type', 'MULTIPLE')->count()}} multiple choice, {{$level->questions()->where('answer_type', 'ESSAY')->count()}} essay, {{$level->questions()->where('answer_type', 'CHECKLIST')->count()}} checklist)</p>
                            <p>{{$level->evaluations()->count()}} penilaian diri</p>
                            <p class="font-weight-bold @if($user->answer_sheets()->where('level_id', $level->id)->count() == 0) text-danger @elseif(!$user->answer_sheets()->where('level_id', $level->id)->first()->finished) text-warning @else text-success @endif">Status: @if($user->answer_sheets()->where('level_id', $level->id)->count() == 0) Blank @elseif(!$user->answer_sheets()->where('level_id', $level->id)->first()->finished) On Progress @else Finished @endif</p>
                            <hr class="sidebar-divider">
                            <p class="text-center"><a href="{{route('user-exam-questions', ['level_id' => $level->id])}}">@if($user->answer_sheets()->where('level_id', $level->id)->count() == 0 || !$user->answer_sheets()->where('level_id', $level->id)->first()->finished) Kerjakan Test @else Lihat Hasil @endif</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection