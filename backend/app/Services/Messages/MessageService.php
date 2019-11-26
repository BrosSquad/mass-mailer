<?php


namespace App\Services\Messages;


use App\Dto\CreateMessage;
use App\Jobs\NotifyAllUsers;
use App\Jobs\ParseMessage;
use App\Message;
use App\User;
use RuntimeException;
use Throwable;

class MessageService
{
    /**
     * @param CreateMessage $createMessage
     * @param int $applicationId
     * @param User $user
     * @return Message
     * @throws Throwable
     */
    public function createNewMessage(CreateMessage $createMessage, int $applicationId, User $user): Message
    {
        $message = new Message([
            'text' => $createMessage->text,
            'from_email' => $createMessage->fromEmail,
            'from_name' => $createMessage->fromName,
            'reply_to' => $createMessage->replyTo,
            'subject' => $createMessage->subject,
            'application_id' => $applicationId,
            'mjml' => $createMessage->isMjml
        ]);


        if (!$user->messages()->save($message)) {
            throw new RuntimeException('Cannot save new message');
        }


        if($createMessage->isMjml)
        {
            ParseMessage::dispatch($message)->delay(now()->addSeconds(10));
        }

        NotifyAllUsers::dispatch($message, $user, $applicationId)
            ->delay(now()->addMinutes(1));

        return $message;
    }
}
