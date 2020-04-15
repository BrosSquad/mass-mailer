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
     * @param  \App\User|Application  $user
     * @param  int  $page
     * @param  int  $perPage
     */
    public function get($user, int $page, int $perPage);

    /**
     * @param $userOrApplication
     * @param  int  $id
     *
     * @return \App\Subscription
     */
    public function getOne($userOrApplication, int $id): Subscription;

    /**
     * @param  array  $createSubscriber
     *
     * @param Application|User $userOrApplication
     *
     * @return Subscription
     */
    public function store(array $createSubscriber, $userOrApplication): Subscription;

    /**
     * @param $userOrApplication
     * @param $id
     * @param  array  $data
     *
     * @return \App\Subscription
     */
    public function update($userOrApplication, $id, array $data): Subscription;

    /**
     * @param  int  $application
     * @param  int  $id
     *
     * @return bool
     */
    public function delete(int $application, int $id): bool;
}
