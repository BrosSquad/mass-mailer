<?php


namespace App\Contracts\Applications;


use App\User;
use App\Application;
use App\Dto\CreateApplication;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ApplicationContract
{
    public function getApplications(int $page, int $perPage);

    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @param  int  $id
     *
     * @return \App\Application
     */
    public function getApplication(int $id): Application;

    /**
     * @param  CreateApplication  $createApplication
     * @param  User  $user
     *
     * @return Application
     */
    public function createApplication(CreateApplication $createApplication, User $user): Application;

    /**
     * @throws ModelNotFoundException
     *
     * @param  User  $user
     * @param  int  $appId
     *
     * @return string
     */
    public function generateNewAppKey(int $appId, User $user): string;

    /**
     * @param  int  $appId
     *
     * @return bool
     */
    public function deleteApplication(int $appId): bool;
}
