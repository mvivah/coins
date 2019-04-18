<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliverableProject extends Model
{
    protected $guarded = [];
    protected $table = 'deliverable_project';

    public function tasks(){

        return $this->hasMany('App\Task'); 

    }
}
