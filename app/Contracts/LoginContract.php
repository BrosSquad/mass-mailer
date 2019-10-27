<?php


namespace App\Contracts;


use App\Dto\Login;
use App\Exceptions\IncorrectPassword;
use \Exception;

interface LoginContract
{
    /**
     * @param Login $login
     * @return array
     * @throws IncorrectPassword
     * @throws Exception
     */
    public function login(Login $login): array;
}
