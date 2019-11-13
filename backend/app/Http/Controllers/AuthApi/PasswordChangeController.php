<?php

namespace App\Http\Controllers\AuthApi;

use App\Contracts\Auth\PasswordChangeContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\RequestNewPasswordRequest;

class PasswordChangeController extends Controller
{
    /**
     * @var PasswordChangeContract
     */
    private $passwordChangeService;

    public function __construct(PasswordChangeContract $passwordChangeService)
    {
        $this->passwordChangeService = $passwordChangeService;
    }

    public function requestNewPassword(RequestNewPasswordRequest $request)
    {
        try {
            $this->passwordChangeService->requestChangePassword($request->input('email'));
            return response()->json(['message' => 'Request for password has been sent']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'User is not found'], 404);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $this->passwordChangeService->changePassword($request->user(), $request->input('password'));
            return response()->json(['message' => 'Your password has been changed']);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'An error has occurred while changing password']);
        }
    }
}
