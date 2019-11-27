<?php


namespace App\Contracts\Message;


use App\Dto\CreateMessage;
use App\Exceptions\MjmlException;
use App\Message;
use App\User;
use Throwable;

interface MessageContract
{

    /**
     * @param CreateMessage $createMessage
     * @param int $applicationId
     * @param User $user
     * @return Message
     * @throws MjmlException
     * @throws Throwable
     */
    public function createNewMessage(CreateMessage $createMessage, int $applicationId, User $user): Message;
}
