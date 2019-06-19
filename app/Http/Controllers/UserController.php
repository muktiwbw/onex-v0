<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Level;

class UserController extends Controller
{
    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function index(){
        return view('user.profile', [
            'user' => Auth::user(),
            'levels' => Level::orderBy('id', 'asc')->get(),
        ]);
    }

    public function show_question($level_id, $case_study_number = null, $question_number = null){
        $question;

        if ($case_study_number && $question_number) {
            $question = $case_study_number != 0 ? Level::find($level_id)->case_studies()->where('number', $case_study_number)->first()->questions()->where('number', $question_number)->first() : Level::find($level_id)->questions()->where('number', $question_number)->first();
        }else{
            // level has case study
                // case study has no question
                    // skip
                // case study has question
                    // return question
            // level has no case study
                // return question
            $question = Level::find($level_id)->case_studies()->count() > 0 && Level::find($level_id)->case_studies()->has('questions')->count() > 0 ? Level::find($level_id)->case_studies()->has('questions')->orderBy('number', 'asc')->first()->questions()->orderBy('number', 'asc')->first() : $question = Level::find($level_id)->questions()->orderBy('number', 'asc')->first();
        }

        return view('user.exam', [
            'question' => $question
        ]);
    }

    public function store_answer(Request $request){

    }

    public function finish_exam($level_id){

    }
}
