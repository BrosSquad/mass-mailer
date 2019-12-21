<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RequireAdminPrivileges
{
    /**
     * Handle an incoming request.
     *
     * @throws AuthenticationException
     *
     * @param  Closure  $next
     * @param  Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if ($user === null) {
            throw new AuthenticationException('You are not logged in');
        }

        if ($user->getRoles()->first()->name !== 'admin') {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }
}
