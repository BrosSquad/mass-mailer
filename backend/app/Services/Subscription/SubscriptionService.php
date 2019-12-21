<?php


namespace App\Services\Subscription;


use App\User;
use App\Application;
use RuntimeException;
use App\Contracts\Subscription\SubscriptionContract;
use App\Dto\CreateSubscriber;
use App\Subscription;
use Throwable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubscriptionService implements SubscriptionContract
{
    /**
     * @param \App\User $user
     * @param int       $page
     * @param int       $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSubscribers(User $user, int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        // TODO: Check for permissions
        return Subscription::query()
            ->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @param \App\User $user
     * @param int       $id
     *
     * @return \App\Subscription
     */
    public function getSubscriber(User $user, int $id): Subscription
    {
        // TODO: Check the permission
        /** @var Subscription $subscription */
        $subscription = Subscription::query()->findOrFail($id);

        return $subscription;
    }

    /**
     * @throws Throwable
     *
     * @param int              $appId
     * @param CreateSubscriber $createSubscriber
     *
     * @return Subscription
     */
    public function addSubscriber(CreateSubscriber $createSubscriber, $appId): Subscription
    {
        $application = null;
        /** @var Application $application */
        if (is_int($appId)) {
            $application = Application::query()
                ->findOrFail($appId);
        } elseif ($appId instanceof Application) {
            $application = $appId;
        } else {
            throw new RuntimeException('Application is not found');
        }
        /** @var Subscription $subscription */

        $subscription = Subscription::query()
            ->where('email', '=', $createSubscriber->email)
            ->first();

        if ($subscription === null) {
            $subscription = new Subscription(
                [
                    'email'   => $createSubscriber->email,
                    'name'    => $createSubscriber->name,
                    'surname' => $createSubscriber->surname,
                ]
            );
            $subscription->saveOrFail();
        }

        $appSub = $application->subscriptions()->find($subscription->id);

        if (!$appSub) {
            $application->subscriptions()->attach($subscription->id);
        }

        return $subscription;
    }

    /**
     * @param int $applicationId
     * @param int $id
     *
     * @return bool
     */
    public function unsubscribe(int $applicationId, int $id): bool
    {
        /** @var Application $application */
        $application = Application::with(['subscriptions'])->findOrFail($applicationId);
        return $application->subscriptions()->detach($id) !== 0;
    }
}
