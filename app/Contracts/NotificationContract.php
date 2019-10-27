<?php


namespace App\Contracts;


use App\Dto\CreateNewNotification;
use App\Notify;
use Throwable;

interface NotificationContract
{
    /**
     * @param CreateNewNotification $notification
     * @return Notify
     * @throws Throwable
     */
    public function createNotification(CreateNewNotification $notification): Notify;

}
