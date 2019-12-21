<?php


namespace App\Contracts\Message;


use App\Exceptions\MjmlException;

interface MjmlContract
{
    public const AUTH_TOKEN = 'token';
    public const AUTH_BASIC = 'basic';


    /**
     * @param string $mjml
     * @return string
     * @throws MjmlException
     */
    public function parse(string $mjml): string;
}
