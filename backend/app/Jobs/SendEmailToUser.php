<?php

namespace App\Jobs;

use App\Application;
use App\Message;
use App\Notify;
use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Log;
use League\OAuth1\Client\Server\User;
use SendGrid;

class SendEmailToUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Subscription  */
    private $subscription;

    /** @var User  */
    private $user;

    /** @var Application  */
    private $application;

    /** @var Message  */
    private $message;

    /** @var SendGrid  */
    private $sendGrid;

    /**
     * Create a new job instance.
     *
     * @param Subscription $subscription
     * @param User $user
     * @param Application $application
     * @param Message $message
     * @param SendGrid $sendGrid
     */
    public function __construct(Subscription $subscription, User $user, Application $application, Message $message, SendGrid $sendGrid)
    {
        $this->subscription = $subscription;
        $this->user = $user;
        $this->application = $application;
        $this->message = $message;
        $this->sendGrid = $sendGrid;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Throwable
     */
    public function handle(UrlGenerator $urlGenerator): void
    {
        $url = $urlGenerator->signedRoute('unsub', [
            'application' => $this->application->id,
            'subscriber' => $this->subscription->id,
        ]);

        $html = str_replace([
            '[unsubscribe]',
            '[name]',
            '[surname]',
            '[email]'
        ], [
            $url,
            $this->subscription->name,
            $this->subscription->surname,
            $this->subscription->email,
        ], $this->message->parsed);

        $mail = new SendGrid\Mail\Mail();
        try {
            $mail->setFrom($this->message->from_email, $this->message->from_name);
            $mail->setReplyTo($this->message->reply_to);
            $mail->setSubject($this->message->subject);
            $mail->addTo($this->subscription->email, $this->subscription->name . ' ' . $this->subscription->surname);
            $mail->addContent('text/html', $html);
        } catch (SendGrid\Mail\TypeException $e) {
            Log::error($e->getMessage());
            return;
        }

        $success = false;
        try {
            $response = $this->sendGrid->send($mail);
            $status =$response->statusCode();
            if( $status > 200 && $status < 300) {
                $success = true;
            }
        }catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        $notification = new Notify([
            'email' => $this->subscription->email,
            'success' => $success,
            'application_id' => $this->application->id,
            'message_id' => $this->message->id,
            'subscription_id' => $this->subscription->id,
            'sendgrid_id' => $this->application->sendGridKey->id,
        ]);

        $notification->saveOrFail();
    }
}
