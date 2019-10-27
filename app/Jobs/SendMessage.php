<?php

namespace App\Jobs;

use App\Application;
use App\Dto\Login;
use App\Message;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use SendGrid;
use SendGrid\Mail\Mail;
use SendGrid\Mail\TypeException;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $to;
    public $message;
    private $sendGrid;

    /**
     * Create a new job instance.
     *
     * @param SendGrid $sendGrid
     * @param string $to
     * @param Message $message
     */
    public function __construct(SendGrid $sendGrid, string $to, Message $message)
    {
        $this->message = $message;
        $this->to = $to;
        $this->sendGrid = $sendGrid;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws TypeException
     */
    public function handle()
    {

        // TODO: Validate first if the email exists
        $mail = new Mail();

        $mail->setFrom($this->message->from_email, $this->message->from_name);
        $mail->setSubject($this->message->subject);
        if($this->message->reply_to !== null) {
            $mail->setReplyTo($this->message->reply_to);
        }
        $mail->addTo(new SendGrid\Mail\To($this->to));
        $mail->addContent(new SendGrid\Mail\Content('text/html', $this->message->text));
        try {
            $response = $this->sendGrid->send($mail);
            $status = $response->statusCode();
            $body = $response->body();
            if( $status > 199 && $status < 300 ) {
                Log::info("Message has been successfully sent\n Body: {$body}");
                // TODO: Add new notification
            } else {
                Log::error("An error has occurred\nBody: {$body}\n\nStatus{$status}");
            }
        }catch(Exception $e) {
            Log::critical($e->getMessage());
        }
    }
}
