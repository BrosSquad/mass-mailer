<?php


namespace App\Contracts;


use App\Dto\CreateUser;
use App\User;
use Throwable;

interface UserContract
{
    /**
     * @param CreateUser $createUser
     * @return User
     * @throws Throwable
     */
    public function createUser(CreateUser $createUser): User;
    public function deleteUser();
    public function updateUserAccount();
}
