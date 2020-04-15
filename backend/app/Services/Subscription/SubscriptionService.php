<?php


namespace App\Services\Subscription;


use App\User;
use App\Application;
use App\Subscription;
use App\Dto\CreateSubscriber;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Contracts\Subscription\SubscriptionContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubscriptionService implements SubscriptionContract
{
    /**
     * @param $userOrApplication
     *
     * @return \App\Subscription|\Illuminate\Database\Eloquent\Builder
     */
    private function getSubscribersBuilder($userOrApplication)
    {
        $query = Subscription::query();

        if ($userOrApplication instanceof User) {
        }
        if ($userOrApplication instanceof Application) {
            $query->applications()->where('id', '=', $userOrApplication->id);
        }
        return $query;
    }


    /**
     * @param  User|Application  $userOrApplication
     * @param  int  $page
     * @param  int  $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get($userOrApplication, int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->getSubscribersBuilder($userOrApplication);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     *
     * @param $userOrApplication
     * @param  int  $id
     *
     * @return \App\Subscription
     */
    public function getOne($userOrApplication, int $id): Subscription
    {
        $query = $this->getSubscribersBuilder($userOrApplication);

        return $query->findOrFail($id);
    }

    /**
     * @throws \Throwable
     *
     * @param Application| User $userOrApplication
     * @param  array  $createSubscriber
     *
     * @return Subscription
     */
    public function store(array $createSubscriber, $userOrApplication): Subscription
    {
        if ($userOrApplication instanceof User) {
            // TODO: Check permissions
            $app = Application::query()->firstOrFail($createSubscriber['application_id']);
        }

        /** @var Subscription $subscription */
        $subscription = Subscription::query()
            ->where('email', '=', $createSubscriber['email'])
            ->first();

        if ($subscription === null) {
            $subscription = new Subscription(
                [
                    'email'   => $createSubscriber['email'],
                    'name'    => $createSubscriber['name'],
                    'surname' => $createSubscriber['surname'],
                ]
            );
            $subscription->saveOrFail();
        }

        $app->subscriptions()->attach($subscription->id);

        return $subscription;
    }


    /**
     * @throws \Throwable
     *
     * @param $id
     * @param  array  $data
     * @param $userOrApplication
     *
     * @return \App\Subscription
     */
    public function update($userOrApplication, $id, array $data): Subscription
    {
        $subscriber = $this->getOne($userOrApplication, $id);
        $subscriber->name = $data['name'];
        $subscriber->surname = $data['surname'];
        $subscriber->email = $data['email'];

        $subscriber->saveOrFail();

        return $subscriber;
    }


    /**
     * @param  int  $application
     * @param  int  $id
     *
     * @return bool
     */
    public function delete(int $application, int $id): bool
    {
        return DB::table('application_subscriptions')
                   ->where(
                       [
                           'application_id'  => $application,
                           'subscription_id' => $id,
                       ]
                   )
                   ->delete() > 0;
    }

}
