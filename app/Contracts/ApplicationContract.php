<?php


namespace App\Contracts;


interface ApplicationContract
{
    public function getApplications();
    public function updateSendGridKey(string $key);
    public function createApplication();
    public function deleteApplication(int $id);
    public function updateDatabaseCredentials(int $id);
}
