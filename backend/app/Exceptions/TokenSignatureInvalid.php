<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class TokenSignatureInvalid extends Exception
{
    public function __construct($message = 'Token\'s signature is not valid', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
