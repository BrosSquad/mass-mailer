<?php


namespace App\Contracts\Subscription;


use App\User;
use Throwable;
use App\Application;
use App\Subscription;
use App\Dto\CreateSubscriber;

interface SubscriptionContract
{
    /**
     * @param  \App\User  $user
     * @param  int  $page
     * @param  int  $perPage
     */
    public function getSubscribers(User $user, int $page, int $perPage);


    /**
     * @throws Throwable
     *
     * @param  int|string|Application  $appId
     * @param  CreateSubscriber  $createSubscriber
     *
     * @return Subscription
     */
    public function addSubscriber(CreateSubscriber $createSubscriber, $appId): Subscription;

    /**
     * @param  int  $applicationId
     * @param  int  $id
     *
     * @return bool
     */
    public function unsubscribe(int $applicationId, int $id): bool;
}
