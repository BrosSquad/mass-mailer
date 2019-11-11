<?php


namespace App\Contracts;


interface MassMailerKeyContract
{
    /**
     * @param string $appName
     * @return array ['key' => string, 'public' => string, 'signedKey' => string]
     */
    public function generateKey(string $appName): array;

    public function verifyKey(string $key);
}
