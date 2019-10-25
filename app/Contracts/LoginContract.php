<?php


namespace App\Contracts;


use App\Dto\Login;

interface LoginContract
{
    public function login(Login $login): array;
}
