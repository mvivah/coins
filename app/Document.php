<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;

class Document extends Model
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
    
    public function comments(){
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function associate(){

        return $this->belongsTo('App\Associate', 'commentable');

    }

    public function opportunity(){

        return $this->belongsTo('App\Opportunity', 'commentable');

    }

    public function project(){

        return $this->belongsTo('App\Project', 'commentable');

    }
}
