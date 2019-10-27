<?php


namespace App\Services;


use App\Application;
use App\Contracts\ApplicationContract;
use App\Dto\CreateApplication;
use App\Dto\UpdateApplicationDatabaseCredentials;
use App\SendGridKey;
use App\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ApplicationService implements ApplicationContract
{
    public function getApplications(int $page, int $perPage)
    {
        return Application::query()
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public function getApplication(int $id)
    {
        return Application::query()->find($id);
    }

    public function getApplicationByName(string $name)
    {
        return Application::query()
            ->where('app_name', '=', $name)
            ->firstOrFail();

    }

    public function updateSendGridKey(int $appId, string $key): bool
    {
        return DB::transaction(static function () use ($appId, $key) {
            return SendGridKey::query()
                    ->where('application_id', '=', $appId)
                    ->update(['key' => $key]) > 0;
        });
    }

    /**
     * @param User $user
     * @param CreateApplication $application
     * @return Application
     */
    public function createApplication(User $user, CreateApplication $application): Application
    {
        return DB::transaction(static function () use ($user, $application) {
            $app = new Application([
                'app_name' => $application->appName,
                'db_name' => $application->dbName,
                'db_host' => $application->dbHost,
                'db_driver' => $application->dbDriver,
                'db_user' => $application->dbUser,
                'db_password' => $application->dbPassword,
                'db_table' => $application->dbTable,
                'email_field' => $application->emailField,
            ]);

            if (!$user->applications()->save($app)) {
                throw new RuntimeException('Cannot save new application');
            }

            if (!$app->sendGridKey()->create([
                'key' => $application->sendgridKey,
                'number_of_messages' => $application->sendGridNumberOfMessages
            ])) {
                throw new RuntimeException('Cannot insert new sendgrid key');
            }

            return $app;
        });
    }

    public function deleteApplication(int $id): bool
    {
        return DB::transaction(static function () use ($id) {
            return Application::destroy($id) > 0;
        });
    }

    public function updateDatabaseCredentials(int $id, UpdateApplicationDatabaseCredentials $databaseCredentials): bool
    {
        return DB::transaction(static function () use ($id, $databaseCredentials) {
            return Application::query()->where('id', '=', $id)
                    ->update([
                        'db_name' => $databaseCredentials->dbName,
                        'db_host' => $databaseCredentials->dbHost,
                        'db_driver' => $databaseCredentials->dbDriver,
                        'db_user' => $databaseCredentials->dbUser,
                        'db_password' => $databaseCredentials->dbPassword,
                        'db_table' => $databaseCredentials->dbTable,
                        'email_field' => $databaseCredentials->emailField,
                    ]) > 0;
        });
    }
}
