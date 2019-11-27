<?php

namespace App\Jobs;

use App\Application;
use App\Message;
use App\User;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use RuntimeException;
use SendGrid;

class NotifyAllUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message;
    private $user;
    private $application;

    /**
     * Create a new job instance.
     *
     * @param Message $message
     * @param User $user
     * @param int|Application $applicationId
     */
    public function __construct(Message $message, User $user, $applicationId)
    {
        $this->message = $message;
        $this->user = $user;

        if(is_int($applicationId))
        {
            $this->application = Application::query()->with(['sendGridKey'])->findOrFail($applicationId);
        } else if($applicationId instanceof Application){
            $this->application = $applicationId;
        } else {
            throw new RuntimeException('Application is not found');
        }

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $sendAt = CarbonImmutable::now()->addSeconds(30);
        $sendgrid = new SendGrid($this->application->sendGridKey->key);
        $this->application->subscriptions()->chunk(500, function ($subs) use (&$sendAt, $sendgrid) {
           foreach($subs as $sub) {
                SendEmailToUser::dispatch($sub, $this->application, $this->message, $sendgrid)
                    ->delay($sendAt);
           }
           $sendAt = $sendAt->addHour();
           // TODO: Send notification to the
        });

    }
}
