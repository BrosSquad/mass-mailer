<?php


namespace App\Contracts\Applications;


use App\Application;
use App\Dto\CreateApplication;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ApplicationContract
{
    public function getApplications();

    public function getApplication(int $id): Application;

    /**
     * @param CreateApplication $createApplication
     * @param User $user
     * @return Application
     */
    public function createApplication(CreateApplication $createApplication, User $user): Application;

    /**
     * @param int $appId
     * @param User $user
     * @return string
     * @throws ModelNotFoundException
     */
    public function generateNewAppKey(int $appId, User $user): string;

    /**
     * @param int $appId
     * @return bool
     */
    public function deleteApplication(int $appId): bool;
}
