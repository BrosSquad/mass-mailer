<?php

namespace App\Providers;

use App\Contracts\Auth\PasswordChangeContract;
use App\Contracts\LoginContract;
use App\Contracts\MassMailerKeyContract;
use App\Contracts\Signer\RsaSignerContract;
use App\Contracts\UserContract;
use App\Services\Auth\MassMailerKey;
use App\Services\Auth\PasswordChangeService;
use App\Services\LoginService;
use App\Services\Signer\RsaSigner;
use App\Services\UserService;
use App\User;
use Hashids\Hashids;
use Hashids\HashidsInterface;
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
        $this->mergeConfigFrom(__DIR__ . '/../../config/hashids.php', 'hashids');

        $this->app->singleton(MassMailerKeyContract::class, MassMailerKey::class);
        $this->app->singleton(RsaSignerContract::class, RsaSigner::class);
        $this->app->singleton(LoginContract::class, LoginService::class);
        $this->app->singleton(UserContract::class, UserService::class);
        $this->app->singleton(PasswordChangeContract::class, PasswordChangeService::class);
        $this->app->singleton(HashidsInterface::class, static function () {
            ['salt' => $salt, 'length' => $length] = config('hashids');

            return new Hashids($salt, $length);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @param HashidsInterface $hashids
     * @return void
     */
    public function boot(HashidsInterface $hashids): void
    {
        User::setHashids($hashids);
    }
}
