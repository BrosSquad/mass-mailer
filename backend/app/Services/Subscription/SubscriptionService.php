<?php


namespace App\Services\Subscription;


use App\Application;
use App\Contracts\Subscription\SubscriptionContract;
use App\Dto\CreateSubscriber;
use App\Subscription;
use Illuminate\Support\Facades\DB;
use RuntimeException;
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
     * @param int $id
     * @return bool
     */
    public function unsubscribe(int $id): bool
    {
        DB::beginTransaction();
        if (Subscription::destroy($id) === 0) {
            DB::rollBack();
            throw new RuntimeException('Cannot delete subscriber');
        }

        DB::commit();

        return true;
    }
}
