<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class IncorrectPassword extends Exception
{
    public function __construct($message = 'Incorrect credentials', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
