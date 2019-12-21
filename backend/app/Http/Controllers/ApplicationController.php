<?php

namespace App\Http\Controllers;

use Throwable;
use Exception;
use Illuminate\Http\Request;
use App\Contracts\Applications\ApplicationContract;
use App\Dto\CreateApplication;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\CreateAppKey;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApplicationController extends Controller
{
    private ApplicationContract $applicationService;

    public function __construct(ApplicationContract $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function getApplications(Request $request)
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

    public function getApplication(int $id, Request $request)
    {
        try {
            return ok(
                [
                    'data' => $this->applicationService->getApplication($request->user(), $id),
                ]
            );
        } catch (ModelNotFoundException $e) {
            return notFound(['message' => 'Application with id: ' . $id . ' is not found']);
        }
    }

    public function createApplication(ApplicationRequest $request)
    {
        $createApplication = new CreateApplication($request->validated());

        try {
            $app = $this->applicationService->createApplication($createApplication, $request->user());
            return created(['application' => $app]);
        } catch (Exception $e) {
            return internalServerError($e);
        }
    }

    public function createAppKey(CreateAppKey $request)
    {
        try {
            $key = $this->applicationService->generateNewAppKey($request->input('appId'), $request->user());
            return created(['appKey' => $key]);
        } catch (ModelNotFoundException $e) {
            return notFound(['message' => 'Application is not found']);
        } catch (Exception $e) {
            return internalServerError($e);
        }
    }

    public function deleteAppKey(int $id)
    {
    }

    public function deleteApplication(int $id)
    {
        try {
            $deleted = $this->applicationService->deleteApplication($id);
            return $deleted ? noContent() : internalServerError(['message' => 'Cannot delete application']);
        } catch (Throwable $e) {
            return internalServerError(['message' => 'Cannot delete application']);
        }
    }
}
