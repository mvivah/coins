<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $guarded=[];

    public function user(){

        return $this->belongsTo('App\User');

    }

    public function serviceline(){

        return $this->belongsTo('App\Serviceline');

    }
    
    public function task(){

        return $this->belongsTo('App\Task');

    }
}
