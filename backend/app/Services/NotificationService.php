<?php


namespace App\Services;


use App\Contracts\NotificationContract;
use App\Dto\CreateNewNotification;
use App\Notify;
use Throwable;

class NotificationService implements NotificationContract
{
    /**
     * @param CreateNewNotification $notification
     * @return Notify
     * @throws Throwable
     */
    public function createNotification(CreateNewNotification $notification): Notify
    {
        $n = new Notify([
            'email' => $notification->email,
            'application_id' => $notification->applicationId,
            'message_id' => $notification->messageId,
            'success' => $notification->success
        ]);

        $n->saveOrFail();

        return $n;
    }

}
