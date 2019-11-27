<?php

namespace App\Providers;

use App\Contracts\Applications\ApplicationContract;
use App\Contracts\MassMailerKeyContract;
use App\Contracts\Message\MessageContract;
use App\Contracts\Subscription\SubscriptionContract;
use App\Contracts\User\ChangeImageContract;
use App\Services\Applications\ApplicationService;
use App\Services\Auth\MassMailerKey;
use App\Services\Messages\MessageService;
use App\Services\Subscription\SubscriptionService;
use App\Services\User\ChangeImage;
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
