<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $guarded=[];

    public function user(){

        return $this->belongsTo('App\User');

    }

    public function comments(){

        return $this->morphMany('App\Comment', 'commentable');

    }

    public function serviceline(){

        return $this->belongsTo('App\Serviceline');

    }

    public function opportunities(){

        return $this->belongsToMany('App\Opportunity');

    }

    public function projects(){

        return $this->belongsToMany('App\Project');
        
    }
}
