<?php


namespace App\Exceptions\RsaSigning;


use Throwable;

class TokenBadlyFormatted extends \Exception
{
    public function __construct($message = 'Token is badly formatted', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
