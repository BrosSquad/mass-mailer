<?php


namespace App\Contracts\Auth;


use App\User;
use Throwable;

interface PasswordChangeContract
{
    /**
     * Changes user password
     * @param User $user
     * @param string $newPassword
     * @return bool
     * @throws Throwable
     */
    public function changePassword(User $user, string $newPassword): bool;

    /**
     * @param string $email
     * @throws Throwable
     */
    public function requestChangePassword(string $email);
}
