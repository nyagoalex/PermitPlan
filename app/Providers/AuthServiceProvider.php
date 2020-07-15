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
        'App\Model' => 'Sp5\Policies\ModelPolicy',
        ];
    
        /**
         * Register any authentication / authorization services.
         *
         * @return void
         */
        public function boot()
        {
            $this->registerPolicies();
            //tokens expiry after 8 hours
            Passport::tokensExpireIn(now()->addMinutes(480));
            $this->registerAccessPolicies();
        }
    
        public function registerAccessPolicies()
        {
        }
}
