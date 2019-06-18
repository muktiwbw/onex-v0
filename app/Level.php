<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'name', 'tujuan', 'uraian',
    ];

    public function questions(){
        return $this->hasMany('App\Question');
    }

    public function case_studies(){
        return $this->hasMany('App\CaseStudy');
    }

    public function evaluations(){
        return $this->hasMany('App\Evaluation');
    }
}
