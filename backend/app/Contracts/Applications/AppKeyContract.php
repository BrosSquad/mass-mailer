<?php


namespace App\Contracts\Applications;


use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AppKeyContract
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
    public function getAppKeys(User $user, int $page, int $perPage): LengthAwarePaginator;

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
    public function generateNewAppKey(int $appId, User $user): string;

    /**
     * @throws \Spatie\Permission\Exceptions\UnauthorizedException
     * @throws \Throwable
     *
     * @param  int  $id
     * @param  User  $user
     *
     * @return bool
     */
    public function deleteKey(User $user, int $id): bool;
}
