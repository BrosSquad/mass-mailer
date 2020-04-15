<?php

namespace App\Jobs;

use App\User;
use SendGrid;
use App\Message;
use App\Application;
use App\Subscription;
use RuntimeException;
use Carbon\CarbonImmutable;
use Illuminate\Bus\Queueable;
use App\Notifications\AllMailsQueued;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyAllUsers implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    private Message $message;
    private User $user;
    private $application;

    /**
     * Create a new job instance.
     *
     * @param  Message  $message
     * @param  User  $user
     * @param  int|Application  $applicationId
     */
    public function __construct(Message $message, User $user, $applicationId)
    {
        $this->message = $message;
        $this->user = $user;

        if (is_int($applicationId)) {
            $this->application = Application::query()->with(['sendGridKey'])->findOrFail($applicationId);
        } elseif ($applicationId instanceof Application) {
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
        $this->application
            ->subscriptions()
            ->orderByDesc('updated_at')
            ->cursor()
            ->each(
                function (Subscription $item, int $index) use (&$sendAt, $sendgrid) {
                    SendEmailToUser::dispatch($item, $this->application, $this->message, $sendgrid)->delay($sendAt);
                    if ($index % 500 === 0) {
                        $sendAt = $sendAt->addHour();
                    }
                }
            );
        $this->user->notify(new AllMailsQueued($sendAt->diffForHumans()));
    }
}
