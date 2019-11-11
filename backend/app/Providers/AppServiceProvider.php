<?php

namespace App\Providers;

use App\Contracts\Image\SaveFileContract;
use App\Contracts\MassMailerKeyContract;
use App\Contracts\User\ChangeImageContract;
use App\Services\Auth\MassMailerKey;
use App\Services\Image\PublicSaveFile;
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
