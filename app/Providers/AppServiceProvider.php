<?php

namespace App\Providers;

use App\Contracts\ApplicationContract;
use App\Contracts\LoginContract;
use App\Contracts\MessageContract;
use App\Contracts\NotificationContract;
use App\Contracts\UserContract;
use App\Services\ApplicationService;
use App\Services\LoginService;
use App\Services\MessageService;
use App\Services\NotificationService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(ApplicationContract::class, ApplicationService::class);
        $this->app->singleton(LoginContract::class, LoginService::class);
        $this->app->singleton(MessageContract::class, MessageService::class);
        $this->app->singleton(UserContract::class, UserService::class);
        $this->app->singleton(NotificationContract::class, NotificationService::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
