<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Level;
use App\AnswerSheet;
use App\Answer;
use App\Question;
use App\Evaluation;
use App\EvaluationAnswer;

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
        if(Auth::user()->answer_sheets()->count() == 0 || Auth::user()->answer_sheets()->where('level_id', $level_id)->count() == 0) AnswerSheet::create([
            'user_id' => Auth::id(),
            'level_id' => $level_id,
        ]);

        if(Auth::user()->answer_sheets()->where('level_id', $level_id)->first()->finished) return redirect()->route('user-exam-result', ['level_id' => $level_id]);

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
            'levels' => Level::all(),
            'question' => $question,
            'answer' => Answer::where('answer_sheet_id', Auth::user()->answer_sheets()->where('level_id', $level_id)->first()->id)->where('question_id', $question->id)->count() > 0 ? Answer::where('answer_sheet_id', Auth::user()->answer_sheets()->where('level_id', $level_id)->first()->id)->where('question_id', $question->id)->first() : null,
        ]);
    }

    public function store_answer(Request $request){
        $question = Question::find($request->question_id);

        $fields = [
            'type' => $question->answer_type,
            'answer_sheet_id' => Auth::user()->answer_sheets()->where('level_id', $question->level->id)->first()->id,
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

        if(Answer::where('answer_sheet_id', $fields['answer_sheet_id'])->where('question_id', $fields['question_id'])->count() > 0){
            $answer = Answer::where('answer_sheet_id', $fields['answer_sheet_id'])->where('question_id', $fields['question_id'])->first();

            switch ($answer->type) {
                case 'MULTIPLE':
                    $answer->point = $request->mc_answer;
                    break;
                    
                case 'ESSAY':
                    $answer->essay = $request->essay;
                    break;
                
                case 'CHECKLIST':
                    $answer->checklists = json_encode($request->cl_answer);
                    break;
            }

            $answer->save();
        }else{
            Answer::create($fields);
        }
        
        $case_study_number;
        $question_number;

        // Penentuan redirect ke nomor atau studi kasus selanjutnya secara berurutan
        // Jika pertanyaan punya studi kasus
        if ($question->case_study()->count() > 0) {
            // Jika dalam studi kasus ada nomor selanjutnya dari nomor saat ini 
            if($question->case_study->questions()->where('number', '>', $question->number)->count() > 0){
                $case_study_number = $question->case_study->number;
                $question_number = $question->case_study->questions()->where('number', '>', $question->number)->orderBy('number', 'asc')->first()->number;
            // Jika dalam level ada studi kasus yang punya pertanyaan dengan nomor selanjutnya dari nomor studi kasus saat ini 
            }elseif($question->level->case_studies()->has('questions')->where('number', '>', $question->case_study->number)->count() > 0){
                $case_study_number = $question->level->case_studies()->has('questions')->where('number', '>', $question->case_study->number)->orderBy('number', 'asc')->first()->number;
                $question_number = $question->level->case_studies()->has('questions')->where('number', '>', $question->case_study->number)->orderBy('number', 'asc')->first()->questions()->orderBy('number', 'asc')->first()->number;
            // Jika ada pertanyaan yang tidak punya studi kasus
            }elseif($question->level->questions()->doesnthave('case_study')->count() > 0){
                $case_study_number = 0;
                $question_number = $question->level->doesnthave('questions')->orderBy('number', 'asc')->first()->questions()->orderBy('number', 'asc')->first()->number;
            }else{
                $case_study_number = $question->level->case_studies()->has('questions')->orderBy('number', 'asc')->first()->number;
                $question_number = $question->level->case_studies()->has('questions')->orderBy('number', 'asc')->first()->questions()->orderBy('number', 'asc')->first()->number;
            }
        // Jika pertanyaan tidak punya studi kasus
        }else{
            // Jika dalam level ada pertanyaan selanjutnya dari pertanyaan saat ini yang tidak punya studi kasus
            if($question->level->questions()->doesnthave('case_study')->where('number', '>', $question->number)->count() > 0){
                $case_study_number = 0;
                $question_number = $question->level->questions()->doesnthave('case_study')->where('number', '>', $question->number)->orderBy('number', 'asc')->first()->number;
            // Jika dalam level ada studi kasus yang punya pertanyaan
            }elseif($question->level->case_studies()->has('questions')->count() > 0){
                $case_study_number = $question->level->case_studies()->has('questions')->orderBy('number', 'asc')->first()->number;
                $question_number = $question->level->case_studies()->has('questions')->orderBy('number', 'asc')->first()->questions()->orderBy('number', 'asc')->first()->number;
            }else{
                $case_study_number = 0;
                $question_number = $question->level->questions()->doesnthave('case_study')->orderBy('number', 'asc')->first()->number;
            }
        }

        return redirect()->route('user-exam-questions', [
            'level_id' => $question->level->id,
            'case_study_number' => $case_study_number,
            'question_number' => $question_number,
        ]);
    }

    public function finish_exam($level_id){
        return Auth::user()->answer_sheets()->where('level_id', $level_id)->first()->evaluation_answers()->count() > 0 ? redirect()->route('user') : redirect()->route('user-exam-evaluation', ['level_id' => $level_id]);
    }
    
    public function show_evaluation($level_id){
        return Auth::user()->answer_sheets()->where('level_id', $level_id)->first()->evaluation_answers()->count() > 0 ? redirect()->route('user-exam-result', ['level_id' => $level_id]) : view('user.evaluation', [
            'level' => Level::find($level_id),
            ]);
        }
        
    public function store_evaluation(Request $request){
        if(!Auth::user()->answer_sheets()->where('level_id', $request->level_id)->first()->finished) Auth::user()->answer_sheets()->where('level_id', $request->level_id)->first()->update(['finished' => true]);
        // Loop based on evaluations di database, bukan dari radio di DOM karena create evaluation answer butuh evaluation id
        // Maka dari itu memastikan urutannya sama dengan orderBy number di method ini maupun di DOM (evaluation.blade.php)
        foreach (Level::find($request->level_id)->evaluations()->orderBy('number', 'asc')->get() as $key => $eval) {
            EvaluationAnswer::create([
                'answer' => $request->eval[$key],
                'answer_sheet_id' => Auth::user()->answer_sheets()->where('level_id', $request->level_id)->first()->id,
                'evaluation_id' => $eval->id
            ]);
        }

        return redirect()->route('user-exam-result', ['level_id' => $request->level_id]);
    }

    public function show_result($level_id){
        $totalScore = 0;
        $answers = Auth::user()->answer_sheets()->where('level_id', $level_id)->first()->answers()->get();

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

        return view('user.exam_result', [
            'answer_sheet' => Auth::user()->answer_sheets()->where('level_id', $level_id)->first(),
            'total_score' => $totalScore
        ]);
    }

    public function reset_exam($level_id){
        Auth::user()->answer_sheets()->where('level_id', $level_id)->first()->answers()->delete();
        Auth::user()->answer_sheets()->where('level_id', $level_id)->first()->evaluation_answers()->delete();
        Auth::user()->answer_sheets()->where('level_id', $level_id)->first()->delete();

        return redirect()->route('user-exam-questions', ['level_id' => $level_id]);
    }
}
