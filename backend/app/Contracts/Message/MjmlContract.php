<?php


namespace App\Contracts\Message;


interface MjmlContract
{
    public const AUTH_TOKEN = 'token';
    public const AUTH_BASIC = 'basic';

    public function parse(string $mjml): string;
}
