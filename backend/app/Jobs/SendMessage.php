<?php

namespace App\Jobs;

use App\Application;
use App\Contracts\NotificationContract;
use App\Dto\CreateNewNotification;
use App\Message;
use Exception;
use Illuminate\Bus\Queueable;
use Egulias\EmailValidator\EmailValidator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use SendGrid;
use SendGrid\Mail\Mail;
use SendGrid\Mail\TypeException;
use Throwable;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $to;
    private $message;
    private $sendGrid;
    private $application;

    /**
     * Create a new job instance.
     *
     * @param Application $application
     * @param SendGrid $sendGrid
     * @param string $to
     * @param Message $message
     */
    public function __construct(Application $application, SendGrid $sendGrid, string $to, Message $message)
    {
        $this->message = $message;
        $this->to = $to;
        $this->sendGrid = $sendGrid;
        $this->application = $application;
    }

    /**
     * Execute the job.
     *
     * @param NotificationContract $notificationContract
     * @return void
     * @throws TypeException
     */
    public function handle(NotificationContract $notificationContract): void
    {

        $validators = new MultipleValidationWithAnd([
            new RFCValidation(),
            new DNSCheckValidation()
        ]);
        
        $emailValidator = new EmailValidator();
        
        if(!$emailValidator->isValid($this->to, $validators)) {
            return;
        }

        // TODO: Validate first if the email exists
        $mail = new Mail();

        $mail->setFrom($this->message->from_email, $this->message->from_name);
        $mail->setSubject($this->message->subject);
        if ($this->message->reply_to !== null) {
            $mail->setReplyTo($this->message->reply_to);
        }
        $mail->addTo(new SendGrid\Mail\To($this->to));
        $mail->addContent(new SendGrid\Mail\Content('text/html', $this->message->text));
        try {
            $response = $this->sendGrid->send($mail);
            $status = $response->statusCode();
            $body = $response->body();
            $success = false;
            if ($status > 199 && $status < 300) {
                Log::info("Message has been successfully sent\tBody: {$body}\tStatus: {$status}");
                $success = true;

            } else {
                Log::error("An error has occurred\tBody: {$body}\tStatus{$status}");
            }

            $notificationContract->createNotification(new CreateNewNotification([
                'email' => $this->to,
                'application_id' => $this->application->id,
                'message_id' => $this->message->id,
                'success' => $success
            ]));
        } catch (Exception | Throwable $e) {
            Log::critical($e->getMessage());
        }
    }
}
