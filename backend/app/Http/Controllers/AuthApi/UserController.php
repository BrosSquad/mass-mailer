<?php

namespace App\Http\Controllers\AuthApi;

use Throwable;
use App\User;
use App\Http\Resources\UserResource;
use App\Contracts\Auth\UserRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ChangeImageRequest;
use App\Contracts\User\ChangeImageContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    private UserRepository $userService;
    private ChangeImageContract $changeImageContract;

    public function __construct(UserRepository $userContract, ChangeImageContract $changeImageContract)
    {
        $this->userService = $userContract;
        $this->changeImageContract = $changeImageContract;
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @param  \App\Http\Requests\CreateUserRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateUserRequest $request): ?JsonResponse
    {
        $this->authorize('create', User::class);
        try {
            $user = $this->userService->store($request->validated());

            return (new UserResource($user))->toResponse($request)->setStatusCode(CREATED);
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

            $image = $this->changeImageContract->update($type, $request->user(), $file);
            return ok(['image' => $image]);
        } catch (Throwable $e) {
            return internalServerError(['message' => $e->getMessage()]);
        }
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id): ?JsonResponse
    {
        $this->authorize('delete', User::class);
        try {
            if ($this->userService->delete($id)) {
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
