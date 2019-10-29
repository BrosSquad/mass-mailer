<?php

namespace App\Jobs;

use App\Application;
use App\Contracts\NotificationContract;
use App\Dto\CreateNewNotification;
use App\Message;
use Egulias\EmailValidator\Validation\EmailValidation;
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

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $to;
    private $message;
    private $sendGrid;
    private $application;
    private $emailValidator;
    private $validation;

    /**
     * Create a new job instance.
     *
     * @param EmailValidator $emailValidator
     * @param EmailValidation $validation
     * @param Application $application
     * @param SendGrid $sendGrid
     * @param string $to
     * @param Message $message
     */
    public function __construct(EmailValidator $emailValidator, EmailValidation $validation, Application $application, SendGrid $sendGrid, string $to, Message $message)
    {
        $this->message = $message;
        $this->to = $to;
        $this->sendGrid = $sendGrid;
        $this->application = $application;
        $this->emailValidator = $emailValidator;
        $this->validation = $validation;
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

        if(!$this->emailValidator->isValid($this->to, $this->validation)) {
            Log::info("Email ({$this->to}) is invalid");
            return;
        }
        $mail = new Mail();

        $mail->setFrom($this->message->from_email, $this->message->from_name);
        $mail->setSubject($this->message->subject);
        if ($this->message->reply_to !== null) {
            $mail->setReplyTo($this->message->reply_to);
        }
        $mail->addTo(new SendGrid\Mail\To($this->to));
        $mail->addContent(new SendGrid\Mail\Content('text/html', $this->message->text));
        $success = false;
        try {
            $response = $this->sendGrid->send($mail);
            $status = $response->statusCode();
            $body = $response->body();
            if ($status > 199 && $status < 300) {
                Log::info("Message has been successfully sent\tBody: {$body}\tStatus: {$status}");
                $success = true;

            } else {
                Log::error("An error has occurred\tBody: {$body}\tStatus{$status}");
            }
        } catch (Exception $e) {
            Log::critical("An error has occurred {$e->getMessage()}");
        }

        try {
            $notificationContract->createNotification(new CreateNewNotification([
                'email' => $this->to,
                'application_id' => $this->application->id,
                'message_id' => $this->message->id,
                'success' => $success
            ]));
        }catch (Throwable $e) {
            Log::error('Error while saving notification');
        }

    }
}
