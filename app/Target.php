<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $guarded=[];
    
    public function teams(){
        return $this->belongsToMany('App\Team');
    }
}
