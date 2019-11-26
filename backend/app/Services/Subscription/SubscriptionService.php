<?php


namespace App\Services\Subscription;


use App\Application;
use App\Contracts\Subscription\SubscriptionContract;
use App\Dto\CreateSubscriber;
use App\Subscription;
use Throwable;

class SubscriptionService implements SubscriptionContract
{
    /**
     *
     */
    public function getSubscribers()
    {

    }

    /**
     * @param CreateSubscriber $createSubscriber
     * @param int $appId
     * @return Subscription
     * @throws Throwable
     */
    public function addSubscriber(CreateSubscriber $createSubscriber, int $appId): Subscription
    {
        /** @var Application $application */
        $application = Application::query()->findOrFail($appId);

        /** @var Subscription $subscription */
        $subscription = Subscription::query()->where(['email', '=', $createSubscriber->email])->firstOrCreate([
            'name' => $createSubscriber->name,
            'surname' => $createSubscriber->surname,
            'email' => $createSubscriber->email,
        ]);

        $appSub = $application->subscriptions()->findOrNew($subscription->id);

        $appSub->saveOrFail();

        return $subscription;
    }

    /**
     * @param int $applicationId
     * @param int $id
     * @return bool
     */
    public function unsubscribe(int $applicationId, int $id): bool
    {
        /** @var Application $application */
        $application = Application::with(['subscriptions'])->findOrFail($applicationId);
        return $application->subscriptions()->detach($id) !== 0;
    }
}
