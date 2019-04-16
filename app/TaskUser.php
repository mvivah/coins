<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    protected $guarded=[];
    protected $table = 'task_user';
    
    public function timesheet(){

        return $this->belongsTo('App\Timesheet');

    }
}
