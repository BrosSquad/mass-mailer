<?php

namespace App\Http\Controllers\AuthApi;

use Throwable;
use App\Dto\CreateUser;
use App\Http\Resources\User;
use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ChangeImageRequest;
use App\Contracts\User\ChangeImageContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    private UserContract $userService;
    private ChangeImageContract $changeImageContract;

    public function __construct(UserContract $userContract, ChangeImageContract $changeImageContract)
    {
        $this->userService = $userContract;
        $this->changeImageContract = $changeImageContract;
    }

    public function create(CreateUserRequest $request)
    {
        $createUser = new CreateUser($request->validated());
        try {
            $user = $this->userService->createUser($createUser);

            return (new User($user))->toResponse($request)->setStatusCode(CREATED);
        }catch (Throwable $e) {
            return internalServerError(['message' => 'Cannot create user']);
        }
    }

    public function changeImage(ChangeImageRequest $request)
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
        } catch (Throwable $e) {
            return internalServerError(['message' => $e->getMessage()]);
        }
    }

    public function delete(int $id)
    {
        try {
            if ($this->userService->deleteUser($id)) {
                return noContent();
            }
            return badRequest(['message' => 'Cannot delete user']);
        } catch (ModelNotFoundException $e) {
            return notFound(['message' => 'User with ID: '.$id.' is not found']);
        } catch (Throwable $e) {
            return internalServerError(['message' => 'An error has occurred']);
        }
    }
}
