<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $guarded=[];
    
    public function team(){
        return $this->belongsTo('App\Team')->withDefault([
            'id' =>1
        ]);
    }
}
