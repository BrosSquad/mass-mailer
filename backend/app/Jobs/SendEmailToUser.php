<?php

namespace App\Jobs;

use App\Application;
use App\Message;
use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\OAuth1\Client\Server\User;

class SendEmailToUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $subscription;
    private $user;
    private $application;
    private $message;

    /**
     * Create a new job instance.
     *
     * @param Subscription $subscription
     * @param User $user
     * @param Application $application
     * @param Message $message
     */
    public function __construct(Subscription $subscription, User $user, Application $application, Message $message)
    {
        $this->subscription = $subscription;
        $this->user = $user;
        $this->application = $application;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

    }
}
