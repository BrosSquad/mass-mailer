<?php

namespace App\Providers;

use App\Services\User\ChangeImage;
use App\Services\Auth\MassMailerKey;
use App\Services\Messages\MjmlService;
use App\Contracts\Message\MjmlContract;
use Illuminate\Support\ServiceProvider;
use App\Contracts\MassMailerKeyContract;
use App\Services\Messages\MessageService;
use App\Contracts\Message\MessageContract;
use App\Contracts\User\ChangeImageContract;
use App\Services\Applications\ApplicationService;
use App\Services\Subscription\SubscriptionService;
use App\Contracts\Applications\ApplicationContract;
use App\Contracts\Subscription\SubscriptionContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(MjmlContract::class, MjmlService::class);
        $this->app->singleton(MassMailerKeyContract::class, MassMailerKey::class);
        $this->app->singleton(ChangeImageContract::class, ChangeImage::class);
        $this->app->singleton(ApplicationContract::class, ApplicationService::class);
        $this->app->singleton(SubscriptionContract::class, SubscriptionService::class);
        $this->app->singleton(MessageContract::class, MessageService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }
}
