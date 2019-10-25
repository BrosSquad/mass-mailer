<?php


namespace App\Services;


use App\Contracts\LoginContract;
use App\Dto\Login;

class LoginService implements LoginContract
{

    public function login(Login $login): array
    {
        return ['user' => null, 'token' => null];
    }
}
