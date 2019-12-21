<?php


namespace App\Exceptions\RefreshTokens;


use Exception;
use Throwable;

class RefreshTokenNotFound extends Exception
{
    public function __construct(
        $message = 'Refresh token is not found in header',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
