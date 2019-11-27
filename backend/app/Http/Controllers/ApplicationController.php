<?php

namespace App\Http\Controllers;

use App\Contracts\Applications\ApplicationContract;
use App\Dto\CreateApplication;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\CreateAppKey;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApplicationController extends Controller
{
    private $applicationService;

    public function __construct(ApplicationContract $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function getApplications()
    {

    }

    public function getApplication()
    {

    }

    public function createApplication(ApplicationRequest $request)
    {
        $createApplication = new CreateApplication($request->validated());

        try {
            $app = $this->applicationService->createApplication($createApplication, $request->user());
            return created(['application' => $app]);
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
