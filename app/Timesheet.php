<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $guarded=[];

    public function users(){

        return $this->belongsToMany('App\User');

    }

    public function serviceline(){

        return $this->belongsTo('App\Serviceline');

    }
    
    public function tasks(){

        return $this->belongsToMany('App\Task');

    }
}
