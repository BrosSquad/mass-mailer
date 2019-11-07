<?php


namespace App\Exceptions\RsaSigning;


use Exception;
use Throwable;

class SignatureCorrupted extends Exception
{
    public function __construct($message = 'Error while generating signature', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
