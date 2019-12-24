<?php


namespace App\Contracts;


use App\Exceptions\InvalidAppKeyException;

interface MassMailerKeyContract
{
    public const HASH_ALGORITHM = 'sha3-256';

    /**
     * @param  string  $appName
     *
     * @return array
     */
    public function generateKey(string $appName): array;

    /**
     * @throws InvalidAppKeyException
     * @throws \Throwable
     *
     * @param  string  $key
     */
    public function verifyKey(string $key);

}
