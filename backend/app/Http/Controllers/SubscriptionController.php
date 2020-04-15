<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\AuthorizationChecker;
use App\Http\Requests\SubscribeRequest;
use App\Http\Resources\SubscriptionResource;
use App\Contracts\Subscription\SubscriptionRepository;

class SubscriptionController extends Controller
{
    protected SubscriptionRepository $subscriptionService;

    public function __construct(SubscriptionRepository $subscriptionService, AuthorizationChecker $authChecker)
    {
        $this->subscriptionService = $subscriptionService;

        $authChecker->check(
            function ($type) {
                if (strtolower($type) === 'massmailer') {
                    $this->middleware('app_key')->except('delete');
                } else {
                    $this->middleware('auth:api')->except('delete');
                }
            }
        );
    }

    public function get(Request $request): ?JsonResponse
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('perPage', 10);

        $data = $this->subscriptionService->get(
            $request->user() ?? $request->attributes->get('application'),
            $page,
            $perPage
        );

        return ok(SubscriptionResource::collection($data));
    }

    public function getOne(int $id, Request $request): ?JsonResponse
    {
        $data = $this->subscriptionService->getOne(
            $request->user() ?? $request->attributes->get('application'),
            $id
        );

        return ok(new SubscriptionResource($data));
    }

    public function store(SubscribeRequest $request)
    {
        $sub = $this->subscriptionService->store(
            $request->validated(),
            $request->user() ?? $request->attributes->get('application')
        );
        return created(new SubscriptionResource($sub));
    }

    public function update($id, SubscribeRequest $request): ?JsonResponse
    {
        $data = $this->subscriptionService->update(
            $request->user() ?? $request->attributes->get('application'),
            $id,
            $request->validated()
        );
        return ok(new SubscriptionResource($data));
    }

    public function delete($applicationId, $id)
    {
        if ($this->subscriptionService->delete($applicationId, $id)) {
            return view('subscriptions.success');
        }

        return view('errors.500');
    }
}
