<?php

namespace App\Http\Controllers\AuthApi;

use App\Dto\CreateUser;
use App\Http\Resources\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreateUserRequest;
use App\Contracts\User\ChangeImageContract;
use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeImageRequest;

class UserController extends Controller
{
    private UserContract $userService;
    private ChangeImageContract $changeImageContract;

    public function __construct(UserContract $userContract, ChangeImageContract $changeImageContract)
    {
        $this->userService = $userContract;
        $this->changeImageContract = $changeImageContract;
    }

    public function create(CreateUserRequest $request): JsonResponse
    {
        $createUser = new CreateUser($request->validated());
        try {
            return (new User($this->userService->createUser($createUser)))
                ->toResponse($request)->setStatusCode(201);
        } catch (\Throwable $e) {
            return internalServerError($e);
        }
    }

    public function changeImage(ChangeImageRequest $request): JsonResponse
    {
        try {
            $type = $request->input('type');
            $file = null;

            switch ($type) {
                case ChangeImageContract::AVATAR:
                    $file = $request->file('avatar');
                    break;
                case ChangeImageContract::BACKGROUND_IMAGE:
                    $file = $request->file('background');
                    break;
            }

            $image = $this->changeImageContract->changeImage($type, $request->user(), $file);
            return ok(['image' => $image]);
        } catch (\Throwable $e) {
            return internalServerError(['message' => $e->getMessage()]);
        }
    }

    public function delete(int $id): void
    {
    }
}
