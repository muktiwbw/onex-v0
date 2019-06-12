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
    // public function index(Request $request, $level_id = null, $question_id = null, $do = null){
    //     if($do != null){
    //         switch ($do) {
    //             case 'create':
    //                 switch ($question_id) {
    //                     case 'question':
    //                         return $request->method() == 'GET' ? $this->create_question($level_id) : $this->submit_question($request);
    //                         break;
                        
    //                     case 'uraian':
    //                         return $request->method() == 'GET' ? $this->create_uraian($level_id) : null;
    //                         break;
                        
    //                     case 'tujuan':
    //                         # code...
    //                         break;
    //                 }
    //             case 'edit':
    //                 return $this->edit_question($question_id);
    //                 break;
                
    //             case 'delete':
    //                 return $this->delete_question($question_id);
    //                 break;
    //         }
    //     }elseif($question_id != null){
    //         return $this->show_question($question_id);
    //     }elseif($level_id != null){
    //         return $this->show_level($level_id);
    //     }else{    
    //         return view('admin.exams', [
    //             'levels' => Level::all()
    //         ]);
    //     }
    // }

    
    public function index(){
        return view('admin.exams', [
            'levels' => Level::all()
        ]);
    }

    public function show_level($level_id){
        return view('admin.level', [
            'level' => Level::find($level_id),
        ]);
    }
     
    public function create_tujuan($level_id){
        
    }
     
    public function store_tujuan(Request $request){
        
    }
     
    public function create_uraian($level_id){
        return view('admin.create_uraian', [
            'level' => Level::find($level_id)
        ]);
    }
     
    public function store_uraian(Request $request){
        dd($request);
    }

    public function show_question($question_id){

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

    public function store_question(Request $request){
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
        
    // public function create_question($level_id){
    //     // get level
    //     $level = Level::find($level_id);
    //     // get latest number
    //     $newNumber = $level->questions()->count() > 0 ? $level->questions()->orderBy('number', 'desc')->first()->number + 1 : 1;

    //     return view('admin.create_question', [
    //         'level' => $level,
    //         'newNumber' => $newNumber
    //     ]);
    // }
    
    // public function submit_question($request){
    //     // get question
    //     $questionFields = [
    //         'number' => $request->number,
    //         'body' => $request->question_type == 'text' ? $request->body : $this->storeAudio($request->file('audio'), $request->level_id, $request->number),
    //         'level_id' => $request->level_id,
    //     ];
        
    //     if($request->answer_type == 'essay'){
    //         $questionFields['type'] = 'ESSAY';
    //         $questionFields['essay'] = $request->essay;
    //     }
        
    //     // submit question
    //     $question = Question::create($questionFields);
        
    //     // get answers multiple choice
    //     if($request->answer_type == 'multiple'){
    //         $choices = [];
    //         $point = 'a';
            
    //         for($i=0;$i<count($request->multi);$i++){
    //             $choices[] = [
    //                 'point' => $point,
    //                 'body' => $request->multi[$i],
    //                 'question_id' => $question->id
    //             ];
                
    //             if($request->correct == $i){
    //                 $choices[$i]['correct'] = TRUE;
    //             }
                
    //             $point++;
    //         }
            
    //         foreach($choices as $choice){
    //             $submittedChoice = Choice::create($choice);
    //         }
    //     }
        
    //     return redirect()->route('admin-exams', ['level_id' => $request->level_id]);
    // }
    
    // public function storeAudio($audio, $level_id, $number){
    //     return 'files/'.Storage::disk('real_public')->putFileAs('audio', $audio, 'audio_level_'.$level_id.'_number_'.$number.'.'.$audio->getClientOriginalExtension());
    // }
    
    // public function show_question($question_id){
    //     return view('admin.show_question', [
    //         'question' => Question::find($question_id)
    //         ]);
    //     }
        
    // public function edit_question($question_id){
    //     return view('admin.edit_question', [
    //         'question' => Question::find($question_id)
    //     ]);
    // }

    // public function delete_question($question_id){
        
    // }
}
