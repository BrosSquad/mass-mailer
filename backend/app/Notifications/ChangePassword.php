<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Manager;

class ChangePassword extends Notification implements ShouldQueue
{
    use Queueable;

    private $manager;
    private $changePassword;



    /**
     * Create a new notification instance.
     *
     * @param \App\Dto\ChangePassword $changePassword
     * @param JWTAuth $auth
     */
    public function __construct(\App\Dto\ChangePassword $changePassword, Manager $manager)
    {
        $this->changePassword = $changePassword;
        $this->manager = $manager;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $claims = array_merge(['sub' => $this->changePassword->getJWTIdentifier()], $this->changePassword->getJWTCustomClaims());
        $payload = $this->manager->getPayloadFactory()
            ->claims($claims)
            ->setTTL(now()->addMinutes(10)->getTimestamp())
            ->make();

        $this->manager->encode($payload)->get();
//        $this->auth->fromUser()
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
