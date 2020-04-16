<?php


namespace App\Contracts\Applications;


use App\User;
use App\Application;
use Spatie\Permission\Exceptions\UnauthorizedException;

interface ApplicationRepository
{
    /**
     * @throws UnauthorizedException
     *
     * @param  \App\User  $user
     * @param  int  $page
     * @param  int  $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function get(User $user, int $page, int $perPage);

    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws UnauthorizedException
     *
     * @param  User  $user
     * @param  int  $id
     *
     *
     * @return \App\Application
     */
    public function getOne(User $user, int $id): Application;


    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     *
     * @param  \App\User  $user
     * @param  array  $createApplication
     *
     * @return \App\Application
     */
    public function store(array $createApplication, User $user): Application;

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     *
     * @param  array  $data
     * @param  \App\User  $user
     * @param  int  $id
     *
     * @return \App\Application
     */
    public function update(int $id, array $data, User $user): Application;

    /**
     * @throws \Spatie\Permission\Exceptions\UnauthorizedException
     * @throws \Throwable
     *
     * @param  int  $appId
     * @param  User  $user
     *
     * @return bool
     */
    public function deleteApplication(User $user, int $appId): bool;
}
