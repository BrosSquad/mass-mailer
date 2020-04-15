<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreateAppKeyRequest;
use App\Http\Resources\AppKeyResource;
use App\Contracts\Applications\AppKeyRepository;

class AppKeyController extends Controller
{
    private AppKeyRepository $appKeyService;

    /**
     * AppKeyController constructor.
     *
     * @param  \App\Contracts\Applications\AppKeyRepository  $appKeyService
     */
    public function __construct(AppKeyRepository $appKeyService)
    {
        $this->appKeyService = $appKeyService;
    }


    /**
     * @throws \Throwable
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        // TODO: Check permissions
        $data = $this->appKeyService->get(
            $request->user(),
            $request->query('page', 1),
            $request->query('perPage', 10)
        );
        return ok(AppKeyResource::collection($data));
    }

    /**
     * @throws \Throwable
     *
     * @param  \App\Http\Requests\CreateAppKeyRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAppKeyRequest $request): JsonResponse
    {
        // TODO: Check permissions
        $data = $this->appKeyService->store($request->input('appId'), $request->user());
        return created(new AppKeyResource($data));
    }



    /**
     * @throws \Throwable
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id, Request $request): JsonResponse
    {
        // TODO: Check permissions
        $this->appKeyService->delete($request->user(), $id);

        return noContent();
    }
}
