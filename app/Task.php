<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;

class Task extends Model
{
    public $incrementing = false;

    protected $guarded=[];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model)
        {
            $model->id = (string) Uuid::generate();

        });
    }
    
    public function users(){

        return $this->belongsToMany('App\User');

    }

    public function timesheet(){

        return $this->hasMany('App\Timesheet');

    }
    
    public function deliverable(){

        return $this->belongsTo('App\Deliverable');

    }

    public function comments(){

        return $this->morphMany('App\Comment', 'commentable');
        
    }
}
