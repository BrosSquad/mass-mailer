<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Requests\UpdateApplicationRequest;
use App\Contracts\Applications\ApplicationRepository;

class ApplicationController extends Controller
{
    private ApplicationRepository $applicationService;

    public function __construct(ApplicationRepository $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function get(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        $data = $this->applicationService->get($request->user(), $page, $perPage);

        return ok(ApplicationResource::collection($data));
    }

    public function getOne(int $id, Request $request): JsonResponse
    {
        $data = $this->applicationService->getOne($request->user(), $id);
        return ok(new ApplicationResource($data));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     *
     * @param  \App\Http\Requests\ApplicationRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ApplicationRequest $request): JsonResponse
    {
        $app = $this->applicationService->store($request->validated(), $request->user());
        return created(new ApplicationResource($app));
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     *
     * @param $id
     * @param  \App\Http\Requests\UpdateApplicationRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateApplicationRequest $request): JsonResponse
    {
        return ok(
            new ApplicationResource(
                $this->applicationService->update(
                    $id,
                    $request->validated(),
                    $request->user()
                )
            )
        );
    }

    /**
     *
     * @throws \Throwable
     *
     * @param  int  $id
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id, Request $request): JsonResponse
    {
        $deleted = $this->applicationService->deleteApplication($request->user(), $id);
        return $deleted ? noContent() : internalServerError(['message' => 'Cannot delete application']);
    }
}
