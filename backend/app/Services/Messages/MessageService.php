<?php


namespace App\Services\Messages;


use App\Contracts\Message\MessageContract;
use App\Dto\CreateMessage;
use App\Exceptions\MjmlException;
use App\Jobs\NotifyAllUsers;
use App\Message;
use App\User;
use GuzzleHttp\Client;
use RuntimeException;
use Throwable;

class MessageService implements MessageContract
{
    protected Client $httpClient;
    public function __construct(Client $client)
    {
        $this->httpClient = $client;
    }

    /**
     * @param CreateMessage $createMessage
     * @param int $applicationId
     * @param User $user
     * @return Message
     * @throws MjmlException
     * @throws Throwable
     */
    public function createNewMessage(CreateMessage $createMessage, int $applicationId, User $user): Message
    {
        $parsed = $createMessage->text;


        if($createMessage->isMjml)
        {
            $response = $this->httpClient->post(env('MJML_URL') . '/render', [
                'auth' => [env('MJML_APP_ID'), env('MJML_SECRET')],
                'json' => [
                    'mjml' => $createMessage->text
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            if(count($data['errors']) > 0) {
                throw new MjmlException($data['errors']);
            }

            $parsed = $data['html'];
        }

        $message = new Message([
            'text' => $createMessage->text,
            'from_email' => $createMessage->fromEmail,
            'from_name' => $createMessage->fromName,
            'reply_to' => $createMessage->replyTo,
            'subject' => $createMessage->subject,
            'application_id' => $applicationId,
            'mjml' => $createMessage->isMjml,
            'parsed' => $parsed
        ]);


        if (!$user->messages()->save($message)) {
            throw new RuntimeException('Cannot save new message');
        }

        NotifyAllUsers::dispatch($message, $user, $applicationId)
            ->delay(now()->addMinutes(1));

        return $message;
    }
}
