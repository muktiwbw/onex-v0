<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    public function level(){
        return $this->belongsTo('App\Level');
    }
}
