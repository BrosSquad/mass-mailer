<?php


namespace App\Services\Applications;


use App\User;
use App\AppKey;
use App\Application;
use App\SendGridKey;
use RuntimeException;
use App\Dto\CreateApplication;
use Illuminate\Support\Facades\DB;
use App\Contracts\MassMailerKeyContract;
use App\Contracts\Applications\ApplicationContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApplicationService implements ApplicationContract
{
    protected MassMailerKeyContract $keyContract;

    public function __construct(MassMailerKeyContract $keyContract)
    {
        $this->keyContract = $keyContract;
    }

    public function getApplications(int $page, int $perPage)
    {
        return Application::query()
            ->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @param int $id
     *
     * @return \App\Application
     */
    public function getApplication(int $id): Application
    {
        /** @var Application $application */
        $application = Application::query()->findOrFail($id);

        return $application;
    }

    /**
     * @param CreateApplication $createApplication
     * @param User              $user
     *
     * @return Application
     */
    public function createApplication(CreateApplication $createApplication, User $user): Application
    {
        DB::beginTransaction();
        $application = new Application(
            [
                'app_name' => $createApplication->appName,
            ]
        );

        if (!$user->applications()->save($application)) {
            DB::rollBack();
            throw new RuntimeException('Cannot save application');
        }

        $sendGridKey = new SendGridKey(
            [
                'key'                => $createApplication->sendgridKey,
                'number_of_messages' => $createApplication->sendGridNumberOfMessages,
            ]
        );

        if (!$application->sendGridKey()->save($sendGridKey)) {
            DB::rollBack();
            throw new RuntimeException('Cannot save sendgrid key');
        }
        DB::commit();

        return $application;
    }

    /**
     * @throws ModelNotFoundException
     *
     * @param User $user
     * @param int  $appId
     *
     * @return string
     */
    public function generateNewAppKey(int $appId, User $user): string
    {
        DB::beginTransaction();
        /** @var Application $application */
        $application = Application::query()->findOrFail($appId);
        $key = new AppKey(
            [
                'key'     => $this->keyContract->generateKey($application->app_name),
                'user_id' => $user->id,
            ]
        );


        if (!$application->appKeys()->save($key)) {
            DB::rollBack();
            throw new RuntimeException('Cannot save application key');
        }

        return $key->key;
    }

    /**
     * @param int $appId
     *
     * @return bool
     */
    public function deleteApplication(int $appId): bool
    {
        DB::beginTransaction();
        if (Application::destroy($appId) === 0) {
            DB::rollBack();
            throw new RuntimeException('Cannot delete application');
        }
        DB::commit();

        return true;
    }
}
