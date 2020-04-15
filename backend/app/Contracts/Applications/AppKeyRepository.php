<?php


namespace App\Contracts\Applications;


use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AppKeyRepository
{
    /**
     * @throws \Spatie\Permission\Exceptions\UnauthorizedException
     * @throws \Throwable
     *
     * @param  int  $page
     * @param  int  $perPage
     * @param  \App\User  $user
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get(User $user, int $page, int $perPage): LengthAwarePaginator;

    /**
     * @throws ModelNotFoundException
     * @throws \Throwable
     * @throws \Spatie\Permission\Exceptions\UnauthorizedException
     *
     * @param  User  $user
     * @param  int  $appId
     *
     * @return string
     */
    public function store(int $appId, User $user): string;

    /**
     * @throws \Spatie\Permission\Exceptions\UnauthorizedException
     * @throws \Throwable
     *
     * @param  int  $id
     * @param  User  $user
     *
     * @return bool
     */
    public function delete(User $user, int $id): bool;
}
