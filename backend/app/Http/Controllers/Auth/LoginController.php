<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\LoginContract;
use App\Dto\Login;
use App\Exceptions\IncorrectPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LoginController extends Controller
{
    private $loginService;

    public function __construct(LoginContract $loginContract)
    {
        $this->loginService = $loginContract;
    }

    public function login(LoginRequest $request)
    {
        $login = new Login($request->validated());

        try {
            return response()->json($this->loginService->login($login));
        } catch (IncorrectPassword $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User is not found'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
