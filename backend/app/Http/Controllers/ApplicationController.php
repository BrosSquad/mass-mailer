<?php

namespace App\Http\Controllers;

use Throwable;
use App\Application;
use Illuminate\Http\Request;
use App\Dto\CreateApplication;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ApplicationRequest;
use App\Contracts\Applications\ApplicationContract;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApplicationController extends Controller
{
    private ApplicationContract $applicationService;

    public function __construct(ApplicationContract $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function getApplications(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        $user = $request->user();

        return ok(
            [
                'data' => $this->applicationService->getApplications($user, $page, $perPage),
            ]
        );
    }

    public function getApplication(int $id, Request $request): JsonResponse
    {
        try {
            return ok(
                [
                    'data' => $this->applicationService->getApplication($request->user(), $id),
                ]
            );
        } catch (ModelNotFoundException $e) {
            return notFound(['message' => 'Application with id: '.$id.' is not found']);
        }
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @param  \App\Http\Requests\ApplicationRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createApplication(ApplicationRequest $request): JsonResponse
    {
        $this->authorize('create', Application::class);
        $createApplication = new CreateApplication($request->validated());

        try {
            $app = $this->applicationService->createApplication($createApplication, $request->user());
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
