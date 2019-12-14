<?php

namespace App\Providers;

use UonSoftware\LaraAuth\Events\PasswordChangedEvent;
use UonSoftware\LaraAuth\Events\RequestNewPasswordEvent;
use UonSoftware\LaraAuth\Listeners\PasswordChangedListener;
use UonSoftware\LaraAuth\Listeners\RequestNewPasswordListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
        //
    }
}
