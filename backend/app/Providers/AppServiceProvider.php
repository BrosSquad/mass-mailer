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
use App\Services\Applications\AppKeyService;
use App\Services\Applications\SendGridService;
use App\Contracts\Applications\AppKeyRepository;
use App\Services\Applications\ApplicationService;
use App\Services\Subscription\SubscriptionService;
use App\Contracts\Applications\SendGridRepository;
use App\Contracts\Applications\ApplicationRepository;
use App\Contracts\Subscription\SubscriptionRepository;

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
        $this->app->singleton(MessageContract::class, MessageService::class);
        $this->addRepositories();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }


    private function addRepositories(): void
    {
        $this->app->singleton(ApplicationRepository::class, ApplicationService::class);
        $this->app->singleton(SubscriptionRepository::class, SubscriptionService::class);
        $this->app->singleton(AppKeyRepository::class, AppKeyService::class);
        $this->app->singleton(SendGridRepository::class, SendGridService::class);
    }
}
