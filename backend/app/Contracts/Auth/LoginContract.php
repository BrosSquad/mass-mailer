<?php


namespace App\Contracts;


use App\Dto\Login;
use App\Exceptions\IncorrectPassword;
use App\Exceptions\InvalidRefreshToken;
use App\Exceptions\RefreshTokenExpired;
use App\Exceptions\RefreshTokenNotFound;
use App\Exceptions\SignatureCorrupted;
use App\Exceptions\TokenBadlyFormatted;
use App\Exceptions\TokenSignatureInvalid;
use \Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

interface LoginContract
{
    /**
     * @param Login $login
     * @return array
     * @throws IncorrectPassword
     * @throws Exception
     */
    public function login(Login $login): array;


    /**
     * @param string $refreshToken
     * @return array
     * @throws RefreshTokenExpired
     * @throws SignatureCorrupted
     * @throws TokenSignatureInvalid
     * @throws RefreshTokenNotFound
     * @throws TokenBadlyFormatted
     * @throws InvalidRefreshToken
     * @throws ModelNotFoundException
     * @throws Throwable
     */
    public function refreshToken(string $refreshToken): array;
}
