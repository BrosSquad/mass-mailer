<?php

namespace App\Jobs;

use App\Application;
use App\Message;
use App\User;
use App\Subscription;
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

    private Message $message;
    private User $user;
    private Application $application;

    /**
     * Create a new job instance.
     *
     * @param Message         $message
     * @param User            $user
     * @param int|Application $applicationId
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
                    SendEmailToUser::dispatch($item, $this->application, $this->message, $sendgrid)
                        ->delay($sendAt);
                    if ($index % 500 === 0) {
                        $sendAt = $sendAt->addHour();
                        // TODO: Send notification to administrators
                    }
                }
            );
    }
}
