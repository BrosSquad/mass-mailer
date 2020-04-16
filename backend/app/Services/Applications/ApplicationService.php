<?php


namespace App\Services\Applications;


use App\User;
use App\Application;
use RuntimeException;
use Illuminate\Support\Facades\DB;
use App\Contracts\MassMailerKeyContract;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Contracts\Applications\SendGridRepository;
use App\Contracts\Applications\ApplicationRepository;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ApplicationService implements ApplicationRepository
{
    /**
     * @var \App\Contracts\MassMailerKeyContract
     */
    protected MassMailerKeyContract $keyContract;

    /**
     * @var \App\Contracts\Applications\SendGridRepository
     */
    protected SendGridRepository $sendGridRepository;

    /**
     * @var \Illuminate\Contracts\Auth\Access\Gate
     */
    protected Gate $gate;

    public function __construct(MassMailerKeyContract $keyContract, SendGridRepository $sendGridRepository, Gate $gate)
    {
        $this->keyContract = $keyContract;
        $this->sendGridRepository = $sendGridRepository;
        $this->gate = $gate;
    }


    /**
     *
     * @param  int  $page
     * @param  int  $perPage
     * @param  \App\User  $user
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Pagination\LengthAwarePaginator
     */
    public function get(User $user, int $page, int $perPage)
    {
        $builder = Application::query();
        if ($this->gate->check('getApplications', Application::class)) {
            return $builder->paginate($perPage, ['*'], 'page', $page);
        }

        if ($this->gate->check('getOwnApplication', Application::class)) {
            return $builder
                ->where('user_id', '=', $user->id)
                ->paginate($perPage, ['*'], 'page', $page);
        }

        throw new UnauthorizedException(403);
    }


    /**
     *
     * @param  int  $id
     * @param  \App\User  $user
     *
     * @return \App\Application
     */
    public function getOne(User $user, int $id): Application
    {
        $builder = Application::query();

        if ($this->gate->check('getOwnApplication', Application::class)) {
            return $builder->findOrFail($id);
        }

        if ($this->gate->check('getApplications', Application::class)) {
            /** @var Application $application */
            $application = $user->applications()->findOrFail($id);
            return $application;
        }

        throw new UnauthorizedException(403);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     *
     * @param  \App\User  $user
     * @param  array  $createApplication
     *
     * @return \App\Application
     */
    public function store(array $createApplication, User $user): Application
    {
        $this->gate->authorize('create', Application::class);
        return DB::transaction(
            static function () use ($createApplication, $user) {
                $application = new Application(
                    [
                        'app_name' => $createApplication['app_name'],
                        'user_id'  => $user->id,
                    ]
                );

                $application->saveOrFail();

                $this->sendGridRepository->store($createApplication['sendgrid_keys'], $application);

                return $application;
            }
        );
    }


    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Throwable
     *
     * @param  array  $data
     * @param  \App\User  $user
     * @param  int  $id
     *
     * @return \App\Application
     */
    public function update(int $id, array $data, User $user): Application
    {
        $application = Application::query()->findOrFail($id);

        $this->gate->authorize('update', $application);

        $application->app_name = $data['app_name'];

        $application->saveOrFail();

        return $application;
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

        $this->gate->authorize('delete', $application);

        DB::beginTransaction();

        if (!$application->delete()) {
            DB::rollBack();
            throw new RuntimeException('Cannot delete application');
        }

        DB::commit();

        return true;
    }
}
