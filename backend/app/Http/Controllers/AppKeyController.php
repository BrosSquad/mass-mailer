<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreateAppKey;
use App\Contracts\Applications\AppKeyContract;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AppKeyController extends Controller
{
    private AppKeyContract $appKeyService;

    /**
     * AppKeyController constructor.
     *
     * @param  \App\Contracts\Applications\AppKeyContract  $appKeyService
     */
    public function __construct(AppKeyContract $appKeyService)
    {
        $this->appKeyService = $appKeyService;
    }


    public function createAppKey(CreateAppKey $request): JsonResponse
    {
        try {
            $key = $this->appKeyService->generateNewAppKey($request->input('appId'), $request->user());
            return created(['appKey' => $key]);
        } catch (ModelNotFoundException $e) {
            return notFound(['message' => 'Application is not found']);
        } catch (Throwable $e) {
            return internalServerError($e);
        }
    }


    public function deleteAppKey(int $id, Request $request): JsonResponse
    {
        try {
            if ($this->appKeyService->deleteKey($request->user(), $id)) {
                return noContent();
            }
        } catch (UnauthorizedException $e) {
            return forbidden(['message' => $e->getMessage()]);
        } catch (Throwable $e) {
        }

        return internalServerError(
            [
                'message' => 'Cannot delete key with id: '.$id,
            ]
        );
    }
}
