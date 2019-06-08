<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function questions(){
        return $this->hasMany('App\Choice');
    }

    public function level(){
        return $this->belongsTo('App\Level');
    }
}
