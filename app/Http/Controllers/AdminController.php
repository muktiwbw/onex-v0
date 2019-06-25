<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Level;
use App\AnswerSheet;
use App\Question;
use App\CaseStudy;

class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard', [
            'user' => Auth::user(),
            'levels' => Level::all(),
            'participants' => User::whereHas('privilege', function($privilege){
                $privilege->where('type', 'USER');
            })->get(),
            'answer_sheets' => AnswerSheet::where('finished', true),
            'questions' => Question::all(),
            'case_studies' => CaseStudy::all(),
        ]);
    }

    public function index_users(){
        return view('admin.users', [
            'users' => User::all(),
            'levels' => Level::all(),
        ]);
    }

    public function show_user($user_id){
        return view('admin.show_user', [
            'user' => User::find($user_id),
            'answer_sheets' => AnswerSheet::where('finished', true)->whereHas('user', function($user) use($user_id){
                $user->where('id', $user_id);
            })->get(),
            'levels' => Level::all(),
        ]);
    }

    public function show_result($user_id, $level_id){
        $totalScore = 0;
        $answers = User::find($user_id)->answer_sheets()->where('level_id', $level_id)->first()->answers()->get();

        foreach($answers as $answer){
            switch ($answer->type) {
                case 'MULTIPLE':
                    $totalScore += $answer->question->choices()->where('correct', true)->first()->point == $answer->point ? $answer->question->score : 0;
                    break;
                    
                case 'CHECKLIST':
                    $cl_answers = json_decode($answer->checklists);

                    foreach($answer->question->checklists()->orderBy('id', 'asc')->get() as $key => $checklist){
                        $totalScore += $checklist->answer == $cl_answers[$key] ? $checklist->question->score : 0;
                    }
                    break;
            }            
        }

        return view('admin.show_user_result', [
            'answer_sheet' => User::find($user_id)->answer_sheets()->where('level_id', $level_id)->first(),
            'total_score' => $totalScore,
            'levels' => Level::all(),
        ]);
    }
    
}
