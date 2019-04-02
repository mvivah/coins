<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;

class Specialization extends Model
{
    protected $guarded=[];

    public function expertise(){

        return $this->belongsTo('App\Expertise');
        
    }
}
