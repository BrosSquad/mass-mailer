<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class InvalidAppKeyException extends Exception
{
    public function __construct($message = 'App key is not valid', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
