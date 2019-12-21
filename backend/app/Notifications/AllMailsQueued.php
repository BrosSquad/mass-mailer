<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AllMailsQueued extends Notification implements ShouldQueue
{
    use Queueable;

    public $delay = 10;

    protected string $estimatedTime;

    /**
     * Create a new notification instance.
     *
     * @param string $estimatedTime
     */
    public function __construct(string $estimatedTime)
    {
        $this->estimatedTime = $estimatedTime;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param \App\User $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Dear: ' . $notifiable->name)
            ->line('All emails have been queued')
            ->line('Expected completion: ' . $this->estimatedTime)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param User $notifiable
     *
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'Dear: ' . $notifiable->name,
            'All emails have been queued',
            'Expected completion: ' . $this->estimatedTime,
            'Thank you for using our application',
        ];
    }
}
