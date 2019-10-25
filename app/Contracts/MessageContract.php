<?php


namespace App\Contracts;


interface MessageContract
{
    public function getMessages();
    public function createMessage(int $applicationId);
    public function deleteMessage(int $id);
}
