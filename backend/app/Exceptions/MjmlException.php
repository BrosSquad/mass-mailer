<?php


namespace App\Exceptions;


use Exception;

class MjmlException extends Exception
{
    private $errors;

    public function __construct(array $errors, $message = 'Your mjml is invalid')
    {
        parent::__construct($message, 0, null);
        $this->errors = [];
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
