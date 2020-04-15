<?php


namespace App\Services\Applications;


use App\User;
use App\Application;
use App\SendGridKey;
use RuntimeException;
use App\Dto\CreateApplication;
use Illuminate\Support\Facades\DB;
use App\Contracts\MassMailerKeyContract;
use App\Contracts\Applications\ApplicationContract;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ApplicationService implements ApplicationContract
{
    protected MassMailerKeyContract $keyContract;

    public function __construct(MassMailerKeyContract $keyContract)
    {
        $this->keyContract = $keyContract;
    }


    public function getApplications(User $user, int $page, int $perPage)
    {
        $builder = Application::query();
        if ($user->hasPermissionTo('get-applications')) {
            return $builder->paginate($perPage, ['*'], 'page', $page);
        }

        if ($user->hasPermissionTo('get-own-applications')) {
            return $builder
                ->where('user_id', '=', $user->id)
                ->paginate($perPage, ['*'], 'page', $page);
        }

        throw new UnauthorizedException(403);
    }


    public function getApplication(User $user, int $id): Application
    {
        $builder = Application::query();

        if ($user->hasPermissionTo('get-applications')) {
            return $builder->findOrFail($id);
        }

        if ($user->hasPermissionTo('get-own-applications')) {
            /** @var Application $application */
            $application = $user->applications()->findOrFail($id);
            return $application;
        }

        throw new UnauthorizedException(403);
    }

    public function createApplication(CreateApplication $createApplication, User $user): Application
    {
        return DB::transaction(
            static function () use ($createApplication, $user) {
                $application = new Application(
                    [
                        'app_name' => $createApplication->appName,
                    ]
                );

                if (!$user->applications()->save($application)) {
                    throw new RuntimeException('Cannot save application');
                }

                $sendGridKey = new SendGridKey(
                    [
                        'key'                => $createApplication->sendgridKey,
                        'number_of_messages' => $createApplication->sendGridNumberOfMessages,
                    ]
                );

                if (!$application->sendGridKey()->save($sendGridKey)) {
                    throw new RuntimeException('Cannot save sendgrid key');
                }

                return $application;
            }
        );
    }


    /**
     * @throws UnauthorizedException
     * @throws \Throwable
     *
     * @param  int  $appId
     * @param  User  $user
     *
     * @return bool
     */
    public function deleteApplication(User $user, int $appId): bool
    {
        $application = Application::query()->findOrFail($appId);
        throw_if(!$user->can('delete', $application), new UnauthorizedException(403));
        DB::beginTransaction();
        if (!$application->delete()) {
            DB::rollBack();
            throw new RuntimeException('Cannot delete application');
        }
        DB::commit();

        return true;
    }
}
