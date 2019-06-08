<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Level;

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

    public function show_level($level_id){
        $level = Level::find($level_id);

        return view('admin.level', [
            'level' => $level
        ]);
    }
}
