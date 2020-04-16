<?php


namespace App\Contracts;


use App\User;
use App\Application;
use App\Exceptions\InvalidAppKeyException;

interface MassMailerKeyContract
{

    /**
     *
     * @throws \Throwable
     *
     * @param  \App\User  $user
     * @param  \App\Application  $application
     *
     * @return array
     */
    public function generateKey(Application $application, User $user): array;

    /**
     * @throws InvalidAppKeyException
     * @throws \Throwable
     *
     * @param  string  $key
     */
    public function verifyKey(string $key);

}
