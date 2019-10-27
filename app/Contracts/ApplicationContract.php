<?php


namespace App\Contracts;


use App\Dto\CreateApplication;
use App\Dto\UpdateApplicationDatabaseCredentials;
use App\User;

interface ApplicationContract
{
    public function getApplications(int $page, int $perPage);
    public function getApplication(int $id);
    public function getApplicationByName(string $name);
    public function updateSendGridKey(int $appId, string $key);
    public function createApplication(User $user, CreateApplication $application);
    public function deleteApplication(int $id);
    public function updateDatabaseCredentials(int $id, UpdateApplicationDatabaseCredentials $databaseCredentials);
}
