<?php


namespace App\Contracts;


use App\Application;
use App\Dto\CreateApplication;
use App\Http\Resources\Key;
use App\User;
use Throwable;

interface ApplicationContract
{
    /**
     * @param int $page
     * @param int $perPage
     * @param array $orderBy
     * @return mixed
     */
    public function getApplications(int $page, int $perPage, array $orderBy = []);

    /**
     * @param int $id
     * @return mixed
     */
    public function getApplication(int $id);

    /**
     * @param string $name
     * @return Application
     */
    public function getApplicationByName(string $name): Application;

    /**
     * @param int $appId
     * @param string $key
     * @return bool
     */
    public function updateSendGridKey(int $appId, string $key): bool;

    /**
     * @param User $user
     * @param CreateApplication $application
     * @return Application
     */
    public function createApplication(User $user, CreateApplication $application): Application;

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteApplication(int $id);

    /**
     * @param int $id
     * @return Key
     * @throws Throwable
     */
    public function generateNewKey(int $id): Key;
}
