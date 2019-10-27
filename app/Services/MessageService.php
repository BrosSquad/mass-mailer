<?php


namespace App\Services;


use App\Contracts\MessageContract;
use App\Dto\CreateMessage;
use App\Message;
use App\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class MessageService implements MessageContract
{

    public function getMessages(int $page, int $perPage)
    {
        return Message::query()
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function getNumberOfMessagesSentByKey()
    {
//        Notify::query()
//            ->with('sendGridKey')
//            ->select('')
//            ->groupBy('sendgrid_id')
//            ->count();
    }

    public function createMessage(User $user,int $applicationId, CreateMessage $createMessage)
    {
        return DB::transaction(static function () use ($user, $applicationId, $createMessage) {
            $message = new Message([
                'text' => $createMessage->text,
                'from_email' => $createMessage->fromEmail,
                'from_name' => $createMessage->fromName,
                'reply_to' => $createMessage->replyTo,
                'subject' => $createMessage->subject,
                'application_id' => $applicationId
            ]);

            if(!$user->messages()->save($message)) {
                throw new RuntimeException('Message cannot be created');
            }

            return $message;
        });
    }


    public function deleteMessage(int $id): bool
    {
        return DB::transaction(static function () use ($id) {
           return Message::destroy($id) > 0;
        });
    }

    public function getMessage(int $id)
    {
        return Message::with([
            'notified', 'application', 'user'
        ])
            ->orderByDesc('created_at')
            ->findOrFail($id);
    }
}
