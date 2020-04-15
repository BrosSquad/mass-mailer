<?php

namespace App\Http\Controllers;

use Throwable;
use App\Application;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Contracts\Applications\ApplicationRepository;
use Spatie\Permission\Exceptions\UnauthorizedException;

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
     *
     * @param  \App\Http\Requests\ApplicationRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ApplicationRequest $request): JsonResponse
    {
        $this->authorize('create', Application::class);

        try {
            $app = $this->applicationService->store($request->validated(), $request->user());
            return created(['application' => $app]);
        } catch (Throwable $e) {
            return internalServerError($e);
        }
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteApplication(int $id, Request $request): JsonResponse
    {
        try {
            $deleted = $this->applicationService->deleteApplication($request->user(), $id);
            return $deleted ? noContent() : internalServerError(['message' => 'Cannot delete application']);
        } catch (UnauthorizedException $e) {
            return forbidden(['message' => $e->getMessage()]);
        } catch (Throwable $e) {
            return internalServerError(['message' => 'Cannot delete application']);
        }
    }
}
