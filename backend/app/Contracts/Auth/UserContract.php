<?php


namespace App\Contracts;


use App\User;
use Throwable;
use App\Dto\CreateUser;

interface UserContract
{
    /**
     * @throws Throwable
     *
     * @param  CreateUser  $createUser
     *
     * @return User
     */
    public function createUser(CreateUser $createUser): User;

    public function deleteUser(int $id): bool;

    public function updateUserAccount(User $user);
}
