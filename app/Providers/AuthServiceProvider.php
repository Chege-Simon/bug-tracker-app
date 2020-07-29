<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;


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
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function($user){
           return $user->role === 'admin';
        });
        Gate::define('isProduct_manager', function($user){
            return $user->role === 'product_manager';
        });
        Gate::define('isDeveloper', function($user){
            return $user->role === 'developer';
        });
        Gate::define('isUser', function($user){
            return $user->role === 'user';
        });

        Passport::routes();
    }
}
