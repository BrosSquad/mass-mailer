<?php

namespace App\Http\Controllers;

use App\Contracts\ApplicationContract;
use App\Dto\CreateApplication;
use App\Http\Requests\ApplicationRequest;
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
        return response()->json([
            'applications' => $this->applicationService->getApplications($page, $perPage)
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
            'application' => $app
        ]);
    }

    public function create(ApplicationRequest $request)
    {
        try {
            $createApplication = new CreateApplication($request->validated());

            $application = $this->applicationService->createApplication($request->user(), $createApplication);

            return response()->json(['application' => $application], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    //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
    public function update(int $id, Request $request)
    {

    }

    public function updateSendGridKey(int $applicationId, Request $request) {
        try {
            $updated = $this->applicationService->updateSendGridKey($applicationId, $request->input('sendGridKey'));

            if($updated) {
                return response()->json(null, 204);
            }

            return response()->json(null, 500);
        }catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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
