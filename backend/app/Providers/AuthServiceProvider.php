<?php

namespace App\Providers;

use App\User;
use App\AppKey;
use Hashids\Hashids;
use App\Application;
use App\Policies\UserPolicy;
use Hashids\HashidsInterface;
use Laravel\Passport\Passport;
use App\Policies\AppKeyPolicy;
use App\Services\Auth\UserService;
use App\Policies\ApplicationPolicy;
use App\Contracts\Auth\UserRepository;
use App\Contracts\AuthorizationChecker;
use App\Services\AuthorizationChecker as AuthorizationCheckerInstance;
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
        User::class        => UserPolicy::class,
        AppKey::class      => AppKeyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        $this->app->singleton(UserRepository::class, UserService::class);
        $this->app->singleton(AuthorizationChecker::class, AuthorizationCheckerInstance::class);

        $this->app->singleton(
            HashidsInterface::class,
            static function () {
                return new Hashids(env('HASHIDS_SALT'), 15);
            }
        );

        Passport::routes();
    }
}
