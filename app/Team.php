<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded=[];

    public function users(){

        return $this->hasMany('App\User');

    }

    public function targets(){

        return $this->belongsToMany('App\Target');

    }

    public function opportunities(){

        return $this->hasMany('App\Opportunity');

    }

}
