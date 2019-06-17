<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Level;
use App\Question;
use App\Choice;
use App\CaseStudy;
use App\Checklist;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{    
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
        return view('admin.create_tujuan', [
            'level' => Level::find($level_id)
        ]);
    }
     
    public function store_tujuan(Request $request){
        $level = Level::find($request->level_id);
        $level->tujuan = $request->editor;
        $level->save();

        return redirect()->route('admin-level', ['level_id' => $level->id]);
    }
     
    public function create_uraian($level_id){
        return view('admin.create_uraian', [
            'level' => Level::find($level_id)
        ]);
    }
     
    public function store_uraian(Request $request){
        $level = Level::find($request->level_id);
        $level->uraian = $request->editor;
        $level->save();

        return redirect()->route('admin-level', ['level_id' => $level->id]);
    }

    public function create_case_study($level_id){
        return view('admin.create_case_study', [
            'level' => Level::find($level_id)
        ]);
    }

    public function store_case_study(Request $request){
        $level = Level::find($request->level_id);
        
        $newNumber = $level->case_studies()->count() > 0 ? $level->case_studies()->orderBy('number', 'desc')->first()->number + 1 : 1;
        $body = $request->cs_type == 'AUDIO' ? $this->store_audio($request->cs_audio, $level->id, $newNumber) : $request->cs_body;

        $caseStudy = CaseStudy::create([
            'number' => $newNumber,
            'title' => $request->cs_title,
            'body' => $body,
            'type' => $request->cs_type,
            'level_id' => $level->id
        ]);

        return redirect()->route('admin-question-create', ['level_id' => $caseStudy->level->id]);
    }

    public function show_case_study($id){
        return view('admin.show_case_study', [
            'caseStudy' => CaseStudy::find($id)
        ]);
    }

    public function store_audio($audio, $level_id, $number){
        return 'files/'.Storage::disk('real_public')->putFileAs('audio', $audio, 'audio_level_'.$level_id.'_number_'.$number.'.'.$audio->getClientOriginalExtension());
    }

    public function show_question($question_id){
        return view('admin.show_question', [
            'question' => Question::find($question_id)
        ]);
    }

    public function create_question($level_id){
        $level = Level::find($level_id);
        $caseStudies = CaseStudy::where('level_id', $level->id)->get();

        return view('admin.create_question', [
            'level' => $level,
            'caseStudies' => $caseStudies
        ]);
    }

    public function store_question(Request $request){
        $fields = [
            'body' => $request->question_body,
            'answer_type' => $request->answer_type,
            'level_id' => $request->level_id
        ];

        if($request->answer_type == 'ESSAY') $fields['essay'] = $request->essay;
        if($request->case_study != 0) {
            $fields['case_study_id'] = $request->case_study;
            $fields['number'] = Level::find($request->level_id)->case_studies()->find($request->case_study)->questions()->count() > 0 ? Level::find($request->level_id)->case_studies()->find($request->case_study)->questions()->orderBy('number', 'desc')->first()->number + 1 : 1;
        }else{
            $fields['number'] = Level::find($request->level_id)->questions()->doesnthave('case_study')->get()->count() > 0 ? Level::find($request->level_id)->questions()->doesnthave('case_study')->orderBy('number', 'desc')->first()->number + 1 : 1;
        }

        $question = Question::create($fields);

        switch ($request->answer_type) {
            case 'MULTIPLE':
                return $this->store_multiple_choice($request, $question->id);
                break;
            
            case 'CHECKLIST':
                return $this->store_checklist($request, $question->id);
                break;
            
            default:
                return redirect()->route('admin-level', ['level_id' => $request->level_id]);
                break;
        }
    }

    public function edit_question($id){
        return view('admin.edit_question', [
            'question' => Question::find($id)
        ]);
    }

    public function patch_question(Request $request){
        $question = Question::find($request->question_id);

        switch ($question->answer_type) {
            case 'MULTIPLE':
                
                break;
                
            case 'ESSAY':
                $question->case_study_id = $request->case_study != 0 ? $request->case_study : null;
                $question->body = $request->question_body;
                $question->essay = $request->essay;
                $question->save();
                return redirect()->route('admin-question', ['question_id' => $question->id]);
                break;

            case 'CHECKLIST':
                
                break;
        }
    }

    public function store_multiple_choice($request, $question_id){
        $point = 'a';

        foreach ($request->mc_body as $key => $mc_body) {
            $choice = Choice::create([
                'point' => $point,
                'body' => $mc_body,
                'correct' => $request->mc_correct == $key ? true : false,
                'question_id' => $question_id
            ]);
            
            $point++;
        }

        return redirect()->route('admin-level', ['level_id' => $request->level_id]);
    }

    public function store_checklist($request, $question_id){
        foreach ($request->checklist as $key => $cl_body) {
            $fields = [
                'body' => $cl_body,
                'question_id' => $question_id
            ];

            if($request->cl_correct[$key]) $fields['answer'] = $request->cl_correct[$key];
            
            $checklist = Checklist::create($fields);
        }
        
        return redirect()->route('admin-level', ['level_id' => $request->level_id]);
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
