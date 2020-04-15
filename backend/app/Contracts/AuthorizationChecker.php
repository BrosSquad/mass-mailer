<?php


namespace App\Contracts;


use Closure;

interface AuthorizationChecker
{
    public function check(Closure $callback);
}
