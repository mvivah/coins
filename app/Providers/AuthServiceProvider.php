<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        //Senior Management
        $gate->define('isAdmin', function($user){
            return $user->level_id == 1;
        });
        //Directors
        $gate->define('isDirector', function($user){
            return $user->level_id == 2;
        });
        //Consultants
        $gate->define('isConsultant', function($user){
            return $user->level_id == 3;
        });
        //Project Managers
        $gate->define('isProjectManager', function($user){
            return $user->level_id == 4;
        });
    }
}
