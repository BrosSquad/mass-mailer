<?php

namespace App\Providers;

use App\Contracts\Signer\RsaSignerContract;
use App\Services\Signer\RsaSigner;
use Illuminate\Support\ServiceProvider;

class RsaProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/rsa.php', 'rsa');
        $this->app->singleton(RsaSignerContract::class, RsaSigner::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
