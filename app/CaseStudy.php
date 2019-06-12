<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    protected $fillable = [
        'number', 'title', 'body', 'level_id'
    ];

    public function level(){
        return $this->belongsTo('App\Level');
    }
}
