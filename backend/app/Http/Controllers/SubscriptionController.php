<?php

namespace App\Http\Controllers;

use App\Contracts\Subscription\SubscriptionContract;
use App\Dto\CreateSubscriber;
use App\Http\Requests\SubscribeRequest;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionContract $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe($applicationId, SubscribeRequest $request)
    {
        $createSubscriber = new CreateSubscriber($request->validated());
        try {
            $sub = $this->subscriptionService->addSubscriber($createSubscriber, (int)$applicationId);
            return created($sub);
        } catch (\Throwable $e) {
            return internalServerError($e);
        }
    }

    public function unsubscribe(int $applicationId, int $id)
    {
        if ($this->subscriptionService->unsubscribe($applicationId, $id)) {
            return view('subscriptions.success');
        }
        return view('subscriptions.error');
    }
}
