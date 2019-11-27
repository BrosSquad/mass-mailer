<?php


namespace App\Contracts\Subscription;


use App\Application;
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
     * @param int|string|Application $appId
     * @return Subscription
     * @throws Throwable
     */
    public function addSubscriber(CreateSubscriber $createSubscriber, $appId): Subscription;

    /**
     * @param int $applicationId
     * @param int $id
     * @return bool
     */
    public function unsubscribe(int $applicationId, int $id): bool;
}
