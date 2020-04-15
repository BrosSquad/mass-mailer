<?php

namespace App\Providers;

use Hashids\Hashids;
use Hashids\HashidsInterface;
use Laravel\Passport\Passport;
use App\Services\Auth\UserService;
use App\Contracts\Auth\UserContract;
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
    public function boot(): void
    {
        $this->registerPolicies();
        $this->app->singleton(UserContract::class, UserService::class);

        $this->app->singleton(
            HashidsInterface::class,
            static function () {
                return new Hashids(env('HASHIDS_SALT'), 15);
            }
        );

        Passport::routes();
    }
}
