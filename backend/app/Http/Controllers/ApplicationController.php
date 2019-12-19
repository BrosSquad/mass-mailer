<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Dto\CreateApplication;
use App\Http\Requests\CreateAppKey;
use App\Http\Requests\ApplicationRequest;
use App\Contracts\Applications\ApplicationContract;
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
        $page = $request->query('page', 1);
        $perPage = $request->query('perPage', 10);
        return ok(
            [
                'data' => $this->applicationService->getApplications($page, $perPage),
            ]
        );
    }

    public function getApplication(int $id)
    {
        try {
            return ok(['data' => $this->applicationService->getApplication($id)]);
        } catch (ModelNotFoundException $e) {
            return notFound(['message' => 'Application with id ' . $id . ' is not found']);
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
    }
}
