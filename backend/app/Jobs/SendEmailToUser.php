<?php

namespace App\Jobs;

use SendGrid;
use Exception;
use App\Notify;
use App\Message;
use App\Application;
use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailToUser implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    private Subscription $subscription;

    private Application $application;

    private Message $message;

    private SendGrid $sendGrid;

    /**
     * Create a new job instance.
     *
     * @param  Subscription  $subscription
     * @param  Application  $application
     * @param  Message  $message
     * @param  SendGrid  $sendGrid
     */
    public function __construct(
        Subscription $subscription,
        Application $application,
        Message $message,
        SendGrid $sendGrid
    ) {
        $this->subscription = $subscription;
        $this->application = $application;
        $this->message = $message;
        $this->sendGrid = $sendGrid;
    }

    /**
     * Execute the job.
     *
     * @throws \Throwable
     *
     * @param  UrlGenerator  $urlGenerator
     *
     * @return void
     */
    public function handle(UrlGenerator $urlGenerator): void
    {
        $url = $urlGenerator->signedRoute(
            'unsub',
            [
                'application' => $this->application->id,
                'subscriber'  => $this->subscription->id,
            ]
        );

        $html = str_replace(
            [
                '[unsubscribe]',
                '[name]',
                '[surname]',
                '[email]',
            ],
            [
                $url,
                $this->subscription->name,
                $this->subscription->surname,
                $this->subscription->email,
            ],
            $this->message->parsed
        );

        $mail = new SendGrid\Mail\Mail();
        try {
            $mail->setFrom($this->message->from_email, $this->message->from_name);
            $mail->setReplyTo($this->message->reply_to);
            $mail->setSubject($this->message->subject);
            $mail->addTo($this->subscription->email, $this->subscription->name.' '.$this->subscription->surname);
            $mail->addContent('text/html', $html);
        } catch (SendGrid\Mail\TypeException $e) {
            Log::error($e->getMessage());
            return;
        }

        $success = false;
        try {
            $response = $this->sendGrid->send($mail);
            $status = $response->statusCode();
            if ($status > 200 && $status < 300) {
                $success = true;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        $notification = new Notify(
            [
                'email'           => $this->subscription->email,
                'success'         => $success,
                'application_id'  => $this->application->id,
                'message_id'      => $this->message->id,
                'subscription_id' => $this->subscription->id,
                'sendgrid_id'     => $this->application->sendGridKey->id,
            ]
        );

        $notification->saveOrFail();
    }
}
