<?php

namespace App\Http\Middleware;

use App\Contracts\LoginContract;
use App\Exceptions\RefreshTokens\InvalidRefreshToken;
use App\Exceptions\RefreshTokens\RefreshTokenExpired;
use App\Exceptions\RefreshTokens\RefreshTokenNotFound;
use App\Exceptions\RsaSigning\SignatureCorrupted;
use App\Exceptions\RsaSigning\TokenBadlyFormatted;
use App\Exceptions\RsaSigning\TokenSignatureInvalid;
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
            $this->auth->parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            // TODO: Refresh token with database value

            try {
                $data['auth'] = $this->loginService->refreshToken($request->header('X-Refresh-Token', null));
                $this->auth->setToken($data['auth']['token'])->authenticate();

            } catch (ModelNotFoundException $e) {
                return notFound(['message' => 'Refresh token is not found']);
            } catch (
            RefreshTokenExpired |
            RefreshTokenNotFound |
            InvalidRefreshToken |
            SignatureCorrupted |
            TokenBadlyFormatted |
            TokenSignatureInvalid $e
            ) {
                return forbidden(['message' => $e->getMessage()]);
            }

        } catch (JWTException $e) {
            // Just continue
            // If token is not found here, maybe the route is unprotected
            // if route is protected then the authentication will fail
        } catch (\Throwable $e) {
            return internalServerError(['message' => 'Error']);
        }

        /** @var JsonResponse $response */
        $response = $next($request);

        $newData = array_merge($response->getData(true), $data);

        return response()->json($newData, $response->getStatusCode());
    }
}
