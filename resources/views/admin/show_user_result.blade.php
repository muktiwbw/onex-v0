@extends('admin.main')
@section('content')  
    <h2>{{$answer_sheet->level->name}} - Hasil</h2>
    <div id="profile">
        <p>Nama: {{$answer_sheet->user->name}}</p>
        <p>Mulai: {{$answer_sheet->created_at}}</p>
        @if($answer_sheet->report()->count() == 0)
        <p>Skor Total (Multiple choice & Checklist): {{$total_score}}</p>
        @endif
        @if($answer_sheet->report()->count() == 0 && $answer_sheet->level->questions()->where('answer_type', 'ESSAY')->count() > 0)
        <p><a href="{{route('admin-user-essay-check', ['user_id' => $answer_sheet->user_id, 'level_id' => $answer_sheet->level_id])}}">Check Essay</a></p>
        @elseif($answer_sheet->report()->count() == 0 && $answer_sheet->level->questions()->where('answer_type', 'ESSAY')->count() == 0)
        <p><a href="#">Verify</a></p>
        @else
        <p>Skor Total: {{$answer_sheet->report->score}}</p>
        <p>Verified</p>
        @endif
    </div>
@endsection