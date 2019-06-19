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

        // To be added when url only level_id
        if ($case_study_number && $question_number) {
            $question = Level::find($level_id)->case_studies()->where('number', $case_study_number)->first()->questions()->where('number', $question_number)->first();
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
