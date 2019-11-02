<?php

namespace App\Http\Controllers;

use App\Contracts\ApplicationContract;
use App\Dto\CreateApplication;
use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    private $applicationService;

    public function __construct(ApplicationContract $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function getApplications(int $page, int $perPage)
    {
        $applications = $this->applicationService->getApplications($page, $perPage);
        return response()->json([
            'applications' => Application::collection($applications)
        ]);
    }

    public function getApplication(int $id)
    {
        $app = $this->applicationService->getApplication($id);

        if ($app === null) {
            return response()->json([
                'message' => 'Application is not found'
            ], 404);
        }

        return response()->json([
            'application' => new Application($app)
        ]);
    }

    public function create(ApplicationRequest $request)
    {
        try {
            $createApplication = new CreateApplication($request->validated());

            $application = $this->applicationService->createApplication($request->user(), $createApplication);

            return response()->json(['application' => new Application($application)], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function update(int $id, Request $request)
    {

    }

    public function updateSendGridKey(int $applicationId, Request $request) {
        try {
            $updated = $this->applicationService
                ->updateSendGridKey($applicationId, $request->input('sendGridKey'));

            if($updated) {
                return response()->json(null, 204);
            }

            return response()->json(null, 500);
        }catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updateAppKey(int $applicationId) {
        try {
            $key = $this->applicationService->generateNewKey($applicationId);
            return response()->json(['key' => $key], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'An error has occurred']);
        }
    }

    public function delete(int $id)
    {
        try {
            return response()->json(['deleted' => $this->applicationService->deleteApplication($id)]);

        }catch(\Exception $e) {
            return response()->json(['message' => 'Error while deleting message'], 500);
        }
    }

}
