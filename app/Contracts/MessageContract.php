<?php


namespace App\Contracts;


use App\Dto\CreateMessage;
use App\User;

interface MessageContract
{
    public function getMessages(int $page, int $perPage);
    public function createMessage(User $user, int $applicationId, CreateMessage $createMessages);
    public function getNumberOfMessagesSentByKey();
    public function deleteMessage(int $id);
}
