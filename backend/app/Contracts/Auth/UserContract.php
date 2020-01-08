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


    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Throwable
     * @param  int  $id
     *
     * @return bool
     */
    public function deleteUser(int $id): bool;

    public function updateUserAccount(User $user);
}
