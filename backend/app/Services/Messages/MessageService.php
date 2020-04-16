<?php


namespace App\Services\Messages;


use App\User;
use Throwable;
use App\Message;
use RuntimeException;
use GuzzleHttp\Client;
use App\Jobs\NotifyAllUsers;
use App\Exceptions\MjmlException;
use App\Contracts\Message\MjmlContract;
use App\Contracts\Message\MessageContract;

class MessageService implements MessageContract
{
    protected Client $httpClient;
    protected MjmlContract $mjmlService;

    public function __construct(Client $client, MjmlContract $mjmlService)
    {
        $this->httpClient = $client;
        $this->mjmlService = $mjmlService;
    }

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
    public function store(array $createMessage, int $applicationId, User $user): Message
    {
        $message = new Message(
            [
                'text'           => $createMessage['text'],
                'from_email'     => $createMessage['from_email'],
                'from_name'      => $createMessage['from_name'],
                'reply_to'       => $createMessage['reply_to'],
                'subject'        => $createMessage['subject'],
                'application_id' => $applicationId,
                'mjml'           => $createMessage['is_mjml'],
                'parsed'         => $createMessage['is_mjml'] ? $this->mjmlService->parse(
                    $createMessage['text']
                ) : $createMessage['text'],
            ]
        );


        if (!$user->messages()->save($message)) {
            throw new RuntimeException('Cannot save new message');
        }

        NotifyAllUsers::dispatch($message, $user, $applicationId)
            ->delay(now()->addMinutes(1));

        return $message;
    }
}
