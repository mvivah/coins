<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;
class Comment extends Model
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

    public function commentable(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
