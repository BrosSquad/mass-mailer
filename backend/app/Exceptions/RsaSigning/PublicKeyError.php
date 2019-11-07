<?php


namespace App\Exceptions\RsaSigning;


use Exception;
use Throwable;

class PublicKeyError extends Exception
{
    public function __construct($message = 'Error while opening public key', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
