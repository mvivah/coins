<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;
class Evaluation extends Model
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

    public function evaluationable(){

        return $this->morphTo();

    }
    
    public function comments(){

        return $this->morphMany('App\Comment', 'commentable');
        
    }
}
