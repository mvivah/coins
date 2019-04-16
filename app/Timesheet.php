<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $guarded=[];

    public function taskusers(){

        return $this->hasMany('App\TaskUser');

    }

}
