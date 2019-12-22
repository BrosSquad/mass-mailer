<?php


namespace App\Contracts;


interface MassMailerKeyContract
{
    public const HASH_ALGORITHM = 'sha3-256';

    /**
     * @param  string  $appName
     *
     * @return array
     */
    public function generateKey(string $appName): array;

    public function verifyKey(string $key);

}
