<?php


namespace App\Services\Applications;


use App\User;
use App\Application;
use RuntimeException;
use Illuminate\Support\Facades\DB;
use App\Contracts\MassMailerKeyContract;
use App\Contracts\Applications\SendGridRepository;
use App\Contracts\Applications\ApplicationRepository;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ApplicationService implements ApplicationRepository
{
    protected MassMailerKeyContract $keyContract;
    /**
     * @var \App\Contracts\Applications\SendGridRepository
     */
    protected SendGridRepository $sendGridRepository;

    public function __construct(MassMailerKeyContract $keyContract, SendGridRepository $sendGridRepository)
    {
        $this->keyContract = $keyContract;
        $this->sendGridRepository = $sendGridRepository;
    }


    public function get(User $user, int $page, int $perPage)
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


    public function getOne(User $user, int $id): Application
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

    /**
     * @throws \Throwable
     *
     * @param  \App\User  $user
     * @param  array  $createApplication
     *
     * @return \App\Application
     */
    public function store(array $createApplication, User $user): Application
    {
        return DB::transaction(
            static function () use ($createApplication, $user) {
                $application = new Application(
                    [
                        'app_name' => $createApplication['appName'],
                        'user_id'  => $user->id,
                    ]
                );

                $application->saveOrFail();

                $this->sendGridRepository->store(
                    [
                        [
                            'key'            => $createApplication['sendgridKey'],
                            'number_of_keys' => $createApplication['sendGridNumberOfMessages'],
                        ],
                    ],
                    $application
                );

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
