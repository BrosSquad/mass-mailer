<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class RefreshTokenExpired extends Exception
{
    public function __construct($message = 'Refresh token has expired', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
