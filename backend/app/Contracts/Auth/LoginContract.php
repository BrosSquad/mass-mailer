<?php


namespace App\Contracts;


use App\Dto\Login;
use App\Exceptions\IncorrectPassword;
use App\Exceptions\RefreshTokens\InvalidRefreshToken;
use App\Exceptions\RefreshTokens\RefreshTokenExpired;
use App\Exceptions\RefreshTokens\RefreshTokenNotFound;
use App\Exceptions\RsaSigning\SignatureCorrupted;
use App\Exceptions\RsaSigning\TokenBadlyFormatted;
use App\Exceptions\RsaSigning\TokenSignatureInvalid;
use Exception;
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
