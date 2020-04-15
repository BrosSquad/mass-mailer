<?php


namespace App\Contracts;


use App\User;
use App\Application;
use App\Exceptions\InvalidAppKeyException;

interface MassMailerKeyContract
{
    /**
     * @param  \App\Application  $application
     * @param  \App\User  $user
     *
     * @return string
     */
    public function generateKey(Application $application, User $user): string;

    /**
     * @throws InvalidAppKeyException
     * @throws \Throwable
     *
     * @param  string  $key
     */
    public function verifyKey(string $key);

}
