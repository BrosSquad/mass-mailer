<?php


namespace App\Services;


use App\Contracts\MessageContract;
use App\Criteria;
use App\Dto\CreateMessage;
use App\Message;
use App\User;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class MessageService implements MessageContract
{

    public function getMessages(int $page, int $perPage): Paginator
    {
        return Message::query()
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function getNumberOfMessagesSentByKey(): int
    {
        return 0;
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

            if(!is_array($createMessage->criteria)) {
                throw new RuntimeException('Criteria must be and array');
            }

            $criteria = [];
            foreach($createMessage->criteria as $criterion) {
                $criteria[] = new Criteria([
                    'field' => $criterion->field,
                    'operator' => $criterion->operator,
                    'value' => $criterion->value
                ]);
            }

            $message->criteria()->saveMany($criteria);

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
            'notified',
            'application',
            'user'
        ])
            ->orderByDesc('created_at')
            ->findOrFail($id);
    }
}
