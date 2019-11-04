<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RequireAdminPrivileges
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if($user === null) {
            throw new AuthenticationException('You are not logged in');
        }

        if($user->getRoles()->first()->name !== 'admin') {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }
}
