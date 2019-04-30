<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;
class Associate extends Model
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
    
    public function project(){

      return $this->belongsToMany('App\Project')->withPivot('availability','updated_at','notes');

    }

    public function documents(){
        return $this->hasMany('App\Document');
    }
    
    public function comments(){
        return $this->morphMany('App\Comment', 'commentable');
    }
}
