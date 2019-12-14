<?php

namespace App\Listeners;

use Exception;
use App\Events\UserCreated;
use Laravolt\Avatar\Avatar;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contracts\User\ChangeImageContract;

class CreateDefaultAvatar implements ShouldQueue
{
    private ChangeImageContract $imageContract;
    private Avatar $avatar;

    /**
     * Create the event listener.
     *
     * @param \App\Contracts\User\ChangeImageContract $imageContract
     * @param \Laravolt\Avatar\Avatar                 $avatar
     */
    public function __construct(ChangeImageContract $imageContract, Avatar $avatar)
    {
        $this->imageContract = $imageContract;
        $this->avatar = $avatar;
    }

    /**
     * Handle the event.
     *
     * @throws \Throwable
     *
     * @param \App\Events\UserCreated $event
     *
     * @return void
     */
    public function handle(UserCreated $event): void
    {
        $user = $event->getUser();
        $image = $this->avatar
            ->create($user->name . ' ' . $user->surname)
            ->getImageObject();

        try {
            $this->imageContract->changeImage(ChangeImageContract::AVATAR, $user, $image);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
