<?php

namespace App\Providers;

use App\User;
use Hashids\Hashids;
use Hashids\HashidsInterface;
use Illuminate\Support\ServiceProvider;

class HashidsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/hashids.php', 'hashids');
        $this->app->singleton(HashidsInterface::class, static function () {
            ['salt' => $salt, 'length' => $length] = config('hashids');

            return new Hashids($salt, $length);
        });
    }

    /**
     * Bootstrap services.
     *
     * @param HashidsInterface $hashids
     * @return void
     */
    public function boot(HashidsInterface $hashids)
    {
        User::setHashids($hashids);
    }
}
