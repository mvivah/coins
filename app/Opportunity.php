<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;

use DB;

class Opportunity extends Model
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

    public function latestOM(){

        $last = DB::table('opportunities')->latest('om_number')->first();

        if ($last==NULL) {

            $latest = 9500;

        } else {

            $latest = $last->om_number;
        }

        return $latest;
    }
    
    public function project(){

        return $this->hasOne('App\Project');

    }

    public function scores(){

        return $this->hasMany('App\Score');

    }

    public function users(){

        return $this->belongsToMany('App\User');

    }

    public function timesheets(){

        return $this->belongsToMany('App\TaskUser');

    }

    public function contact(){

        return $this->belongsTo('App\Contact');
        
    }

    public function team(){

        return $this->belongsTo('App\Team');
        
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

    public function deliverables(){

        return $this->belongsToMany('App\Deliverable')->withPivot('deliverable_status','deliverable_completion');

    }
}
