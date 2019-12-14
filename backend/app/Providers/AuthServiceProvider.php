<?php

namespace App\Providers;

use App\Services\UserService;
use App\Contracts\UserContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    public function register(): void
    {
        parent::register();
        $this->app->singleton(UserContract::class, UserService::class);
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
        //
    }
}
