<?php


namespace App\Contracts\Applications;


use App\User;
use App\Application;
use App\Dto\CreateApplication;
use Spatie\Permission\Exceptions\UnauthorizedException;

interface ApplicationContract
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
    public function getApplications(User $user, int $page, int $perPage);

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
    public function getApplication(User $user, int $id): Application;

    /**
     * @throws UnauthorizedException
     * @throws \Throwable
     *
     * @param  CreateApplication  $createApplication
     * @param  User  $user
     *
     * @return Application
     */
    public function createApplication(CreateApplication $createApplication, User $user): Application;

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
