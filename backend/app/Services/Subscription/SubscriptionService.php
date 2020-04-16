<?php


namespace App\Services\Subscription;


use App\User;
use App\Application;
use App\Subscription;
use RuntimeException;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Contracts\Subscription\SubscriptionRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubscriptionService implements SubscriptionRepository
{
    /**
     * @var \Illuminate\Contracts\Auth\Access\Gate
     */
    protected Gate $gate;

    public function __construct(Gate $gate) {
        $this->gate = $gate;
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @param $userOrApplication
     *
     * @return \App\Subscription|\Illuminate\Database\Eloquent\Builder
     */
    private function getSubscribersBuilder($userOrApplication)
    {
        $query = Subscription::query();

        if ($userOrApplication instanceof User) {
            $this->gate->authorize('', Subscription::class);
        }
        if ($userOrApplication instanceof Application) {
            $query->applications()->where('id', '=', $userOrApplication->id);
        }
        return $query;
    }


    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @param  int  $page
     * @param  int  $perPage
     *
     * @param  User|Application  $userOrApplication
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @param  int  $id
     *
     * @param $userOrApplication
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
            $this->gate->authorize('create', Subscription::class);
            $app = Application::query()->findOrFail($createSubscriber['application_id']);
        } elseif($userOrApplication instanceof Application) {
            $app = $userOrApplication;
        } else {
            throw new RuntimeException('$userOrApplication parameter needs to be App\\User or App\\Application');
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
