<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Level;
use App\AnswerSheet;
use App\Question;

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
        if(Auth::user()->answer_sheets()->count() == 0 || Auth::user()->answer_sheets->where('level_id', $level_id)->count() == 0) AnswerSheet::create([
            'user_id' => Auth::id(),
            'level_id' => $level_id
        ]);

        $question;

        if ($case_study_number != null && $question_number != null) {
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
        $question = Question::find($request->question_id);

        $fields = [
            'type' => $question->answer_type,
            'answer_sheet_id' => AnswerSheet::where('user_id', Auth::id())->where('level_id', $question->level->id)->first()->id,
            'question_id' => $question->id,
        ];

        switch ($question->answer_type) {
            case 'MULTIPLE':
                $fields['point'] = $request->mc_answer;
                break;
                
            case 'ESSAY':
                $fields['essay'] = $request->essay;
                break;
            
            case 'CHECKLIST':
                $fields['checklists'] = json_encode($request->cl_answer);
                break;
        }

        if ($question->case_study()->count() > 0) {
            
        }else{

        }
    }

    public function finish_exam($level_id){

    }
}
