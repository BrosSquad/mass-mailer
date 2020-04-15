<?php


namespace App\Contracts\Auth;


use App\User;

interface UserRepository
{
    /**
     * @param  array  $createUser
     *
     * @return User
     */
    public function store(array $createUser): User;


    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Throwable
     * @param  int  $id
     *
     * @return bool
     */
    public function delete(int $id): bool;

    public function update(User $user, array $data);
}
