<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class InvalidRefreshToken extends Exception
{
    public function __construct($message = 'Refresh token is invalid', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
