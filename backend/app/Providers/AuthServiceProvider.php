<?php

namespace App\Providers;

use App\User;
use App\Application;
use App\Policies\UserPolicy;
use App\Services\UserService;
use App\Contracts\UserContract;
use App\Policies\ApplicationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Application::class => ApplicationPolicy::class,
        User::class => UserPolicy::class
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
    }
}
