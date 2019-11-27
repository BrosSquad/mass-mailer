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
    public function addSubscriber(CreateSubscriber $createSubscriber, $appId): Subscription
    {
        $application = null;
        /** @var Application $application */
        if(is_int($appId)) {
            $application = Application::query()
                ->findOrFail($appId);
        } else if($appId instanceof Application) {
            $application = $appId;
        } else {
            throw new \RuntimeException('Application is not found');
        }
        /** @var Subscription $subscription */

        $subscription = Subscription::query()
            ->where('email' ,'=', $createSubscriber->email)
            ->first();

        if($subscription === null) {
            $subscription = new Subscription([
                'email' => $createSubscriber->email,
                'name' => $createSubscriber->name,
                'surname' => $createSubscriber->surname,
            ]);
            $subscription->saveOrFail();
        }

        $appSub = $application->subscriptions()->find($subscription->id);

        if(!$appSub) {
            $application->subscriptions()->attach($subscription->id);
        }

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
