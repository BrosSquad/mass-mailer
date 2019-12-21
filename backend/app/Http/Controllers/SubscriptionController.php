<?php

namespace App\Http\Controllers;

use Throwable;
use App\Contracts\Subscription\SubscriptionContract;
use App\Dto\CreateSubscriber;
use App\Http\Requests\SubscribeRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SubscriptionController extends Controller
{
    protected SubscriptionContract $subscriptionService;

    public function __construct(SubscriptionContract $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function getSubscribers(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('perPage', 10);
        return ok(
            [
                'data' => $this->subscriptionService->getSubscribers($request->user(), $page, $perPage),
            ]
        );
    }

    public function getSubscriber(int $id, Request $request)
    {
        try {
            return ok(['data' => $this->subscriptionService->getSubscriber($request->user(), $id)]);
        } catch (ModelNotFoundException $e) {
            return notFound(['message' => 'Subscriber with id: ' . $id . ' is not Found']);
        }
    }

    public function subscribe($applicationId, SubscribeRequest $request)
    {
        $createSubscriber = new CreateSubscriber($request->validated());
        try {
            $sub = $this->subscriptionService->addSubscriber($createSubscriber, (int)$applicationId);
            return created($sub);
        } catch (Throwable $e) {
            return internalServerError($e);
        }
    }

    public function unsubscribe(Request $request)
    {
        $applicationId = $request->query('application');
        $id = $request->query('subscriber');
        if ($this->subscriptionService->unsubscribe($applicationId, $id)) {
            return view('subscriptions.success');
        }
        return view('errors.500');
    }
}
