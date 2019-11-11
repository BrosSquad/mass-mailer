<?php

namespace App\Providers;

use App\Contracts\Auth\PasswordChangeContract;
use App\Contracts\LoginContract;
use App\Contracts\UserContract;
use App\Services\Auth\PasswordChangeService;
use App\Services\LoginService;
use App\Services\UserService;
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

    public function register()
    {
        parent::register();
        $this->app->singleton(LoginContract::class, LoginService::class);
        $this->app->singleton(UserContract::class, UserService::class);
        $this->app->singleton(PasswordChangeContract::class, PasswordChangeService::class);
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
