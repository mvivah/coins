<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;

class Project extends Model
{
    public $incrementing = false;

    protected $guarded=[];

    public static function boot()
    {

      parent::boot();

        self::creating(function ($model){

            $model->id = (string) Uuid::generate();

        });
    }
    
    public function opportunity(){

        return $this->belongsTo('App\Opportunity');

    }

    public function users(){

        return $this->belongsToMany('App\User')->withPivot('availability');

    }

    public function associates(){

        return $this->belongsToMany('App\Associate')->withPivot('availability');

    }

    public function timesheets(){

        return $this->belongsToMany('App\TaskUser');

    }

    public function deliverables(){

        return $this->belongsToMany('App\Deliverable');

    }

    public function documents(){

        return $this->hasMany('App\Document');

    }

    public function comments(){

        return $this->morphMany('App\Comment', 'commentable');

    }

    public function evaluations(){

        return $this->morphMany('App\Evaluation', 'evaluationable');
        
    }
}
