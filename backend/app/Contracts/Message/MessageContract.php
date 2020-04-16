<?php


namespace App\Contracts\Message;


use App\User;
use Throwable;
use App\Message;
use App\Exceptions\MjmlException;

interface MessageContract
{

    /**
     * @throws MjmlException
     * @throws Throwable
     *
     * @param  User  $user
     * @param  array  $createMessage
     * @param  int  $applicationId
     *
     * @return Message
     */
    public function store(array $createMessage, int $applicationId, User $user): Message;
}
