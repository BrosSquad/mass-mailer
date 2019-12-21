<?php


namespace App\Contracts\Message;


use App\Exceptions\MjmlException;

interface MjmlContract
{
    public const AUTH_TOKEN = 'token';
    public const AUTH_BASIC = 'basic';


    /**
     * @throws MjmlException
     *
     * @param  string  $mjml
     *
     * @return string
     */
    public function parse(string $mjml): string;
}
