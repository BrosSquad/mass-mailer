<?php

namespace App\Http\Controllers;

use App\Contracts\Subscription\SubscriptionContract;
use App\Http\Requests\SubscribeRequest;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionContract $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(SubscribeRequest $request)
    {

    }

    public function unsubscribe(int $applicationId, int $id)
    {
        if($this->subscriptionService->unsubscribe($applicationId, $id)) {
            return view('subscriptions.success');
        }
        return view('subscriptions.error');
    }
}
