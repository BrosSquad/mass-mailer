<?php

namespace App\Http\Middleware;

use App\Contracts\LoginContract;
use App\Exceptions\RefreshTokenExpired;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWTAuth;

class RefreshMiddleware
{
    /**
     * @var JWTAuth
     */
    private $auth;

    /**
     * @var LoginContract
     */
    private $loginService;

    public function __construct(JWTAuth $auth, LoginContract $loginService)
    {
        $this->auth = $auth;
        $this->loginService = $loginService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws RefreshTokenExpired
     * @throws \Throwable
     */
    public function handle($request, Closure $next)
    {
        $data = [];

        try {
            $this->auth->parseToken();
        } catch (TokenExpiredException $e) {
            // TODO: Refresh token with database value
            $data = $this->loginService->refreshToken($request->header('X-Refresh-Token'));
        }
        catch (ModelNotFoundException | RefreshTokenExpired $e) {
            return forbidden(['message' => $e->getMessage()]);
        }
        catch (JWTException $e) {
            return unauthorized(['message' => 'Unauthorized']);
        }
        catch (\Throwable $e) {
            return internalServerError(['message' => 'Error']);
        }

        /** @var JsonResponse $response */
        $response = $next($request);

        $newData = array_merge($response->getData(true), $data);

        return response()->json($newData, $response->getStatusCode());
    }
}
