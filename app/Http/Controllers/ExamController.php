<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Level;
use App\Question;
use App\Choice;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{
    public function index($level_id = null, $question_id = null, $do = null){

        if($do != null){

        }elseif($question_id != null){
            if($question_id = 'create'){
                return $this->create_question($level_id);
            }
        }elseif($level_id != null){
            return $this->show_level($level_id);
        }else{
            $levels = Level::all();
    
            return view('admin.exams', [
                'levels' => $levels
            ]);
        }
    }

    public function create_question($level_id){
        // get level
        $level = Level::find($level_id);
        // get latest number
        $newNumber = $level->questions()->count() > 0 ? $level->questions()->orderBy('number', 'desc')->first()->number + 1 : 1;

        return view('admin.create_question', [
            'level' => $level,
            'newNumber' => $newNumber
        ]);
    }

    public function submit_question(Request $request){
        // get question
        $questionFields = [
            'number' => $request->number,
            'body' => $request->question_type == 'text' ? $request->body : $this->storeAudio($request->file('audio'), $request->level_id, $request->number),
            'level_id' => $request->level_id,
        ];
        
        if($request->answer_type == 'essay'){
            $questionFields['type'] = 'ESSAY';
            $questionFields['essay'] = $request->essay;
        }

        // submit question
        $question = Question::create($questionFields);

        // get answers multiple choice
        if($request->answer_type == 'multiple'){
            $choices = [];
            $point = 'a';
    
            for($i=0;$i<count($request->multi);$i++){
                $choices[] = [
                    'point' => $point,
                    'body' => $request->multi[$i],
                    'question_id' => $question->id
                ];
    
                if($request->correct == $i){
                    $choices[$i]['correct'] = TRUE;
                }
    
                $point++;
            }

            foreach($choices as $choice){
                $submittedChoice = Choice::create($choice);
            }
        }

        return redirect()->route('admin-exams', ['level_id' => $request->level_id]);
    }

    public function storeAudio($audio, $level_id, $number){
        return 'files/'.Storage::disk('real_public')->putFileAs('audio', $audio, 'audio_level_'.$level_id.'_number_'.$number.'.'.$audio->getClientOriginalExtension());
    }

    public function show_level($level_id){
        $level = Level::find($level_id);

        return view('admin.level', [
            'level' => $level,
            'questions' => $level->questions
        ]);
    }
}
