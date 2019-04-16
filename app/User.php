<?php

namespace App;
use DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Webpatser\Uuid\Uuid;

class User extends Authenticatable
{
    use Notifiable;

    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model){

            $model->id = (string) Uuid::generate();

        });
    }

    public static function getCreator(){

        $admin = DB::table('users')->latest('id')->first();

        if ($admin!=NULL) {

            $admin = $admin->id;

        } else {

        }

        return $admin;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tasks(){

        return $this->belongsToMany('App\Task');

    }

    public function assessments(){

        return $this->hasMany('App\Assessment')->selectRaw("targets.target_category AS category,assessments.assessment_score/targets.target_value*100 AS score")
                                                ->join('targets', 'assessments.target_id', '=', 'targets.id')
                                                ->groupBy('targets.target_category');
    }

    public function timesheets(){

        return $this->hasMany('App\TaskUser')->selectRaw("targets.target_category AS category,assessments.assessment_score/targets.target_value*100 AS score")
                                                ->join('targets', 'assessments.target_id', '=', 'targets.id')
                                                ->groupBy('targets.target_category');
    }

    public function projects(){

        return $this->belongsToMany('App\Project');

    }

    public function leaves(){

        return $this->hasMany('App\Leave');

    }

    public function role(){

        return $this->belongsTo('App\Role')->withDefault(['id' =>1]);

    }

    public function team(){

        return $this->belongsTo('App\Team')->withDefault(['id' =>1]);

    }

    public function level(){

        return $this->belongsTo('App\Level');

    }

    public function opportunities(){

        return $this->belongsToMany('App\Opportunity');

    }
}

