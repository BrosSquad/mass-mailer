<?php


namespace App\Contracts;


use App\Dto\CreateNewUser;

interface UserContract
{
    public function createUser(CreateNewUser $createNewUser);
    public function deleteUser(int $id);
    public function updateUserAccount();
}
