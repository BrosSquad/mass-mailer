<?php


namespace App\Contracts\Message;


use App\User;
use Throwable;
use App\Message;
use App\Dto\CreateMessage;
use App\Exceptions\MjmlException;

interface MessageContract
{

    /**
     * @throws MjmlException
     * @throws Throwable
     *
     * @param  User  $user
     * @param  CreateMessage  $createMessage
     * @param  int  $applicationId
     *
     * @return Message
     */
    public function createNewMessage(CreateMessage $createMessage, int $applicationId, User $user): Message;
}
