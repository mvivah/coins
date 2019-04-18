<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;

class Serviceline extends Model
{
    protected $guarded=[];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {

            $model->id = (string) Uuid::generate();

        });
    }

    public function timesheet(){

        return $this->belongsTo('App\Timesheet');
        
    }
}