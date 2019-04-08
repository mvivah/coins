<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;

class Deliverable extends Model
{
    public $incrementing = false;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {

            $model->id = (string) Uuid::generate();

        });
    }

    public function projects(){

        return $this->belongsToMany('App\Project');

    }

    public function tasks(){

        return $this->hasMany('App\Task'); 

    }

    public function comments(){

        return $this->morphMany('App\Comment', 'commentable');
        
    }

    public function opportunities(){

        return $this->belongsToMany('App\Opportunity');
        
    }
}
