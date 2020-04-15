<?php


namespace App\Services;

use Closure;
use Illuminate\Http\Request;
use App\Contracts\AuthorizationChecker as AuthorizationCheckerInterface;

class AuthorizationChecker implements AuthorizationCheckerInterface
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function check(Closure $callback)
    {
        $header = $this->request->header('Authorization');

        if($header === null) {
            return $callback(null, null);
        }

        [$type, $token] = explode(' ', $header);

        return $callback($type, $token);
    }
}
