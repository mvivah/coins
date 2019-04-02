<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;

class Contact extends Model
{
    public $incrementing = false;

    protected $guarded=[];

    public static function boot()
    {
      parent::boot();
      self::creating(function ($model) {
        $model->id = (string) Uuid::generate();
      });
    }
    
    public function opportunities(){
        return $this->hasMany('App\Opportunity');
    }

    public function comments(){
        return $this->morphMany('App\Comment', 'commentable');
    }
}
