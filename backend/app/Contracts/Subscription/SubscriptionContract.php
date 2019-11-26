<?php


namespace App\Contracts\Subscription;


use App\Dto\CreateSubscriber;
use App\Subscription;
use Throwable;

interface SubscriptionContract
{
    /**
     *
     */
    public function getSubscribers();


    /**
     * @param CreateSubscriber $createSubscriber
     * @param int $appId
     * @return Subscription
     * @throws Throwable
     */
    public function addSubscriber(CreateSubscriber $createSubscriber, int $appId): Subscription;

    /**
     * @param int $id
     * @return bool
     */
    public function unsubscribe(int $id): bool;
}
