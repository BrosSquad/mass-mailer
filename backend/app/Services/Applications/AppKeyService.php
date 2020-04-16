<?php


namespace App\Services\Applications;


use App\User;
use App\AppKey;
use App\Application;
use Hashids\HashidsInterface;
use Illuminate\Support\Facades\DB;
use App\Contracts\MassMailerKeyContract;
use Illuminate\Contracts\Auth\Access\Gate;
use App\Contracts\Applications\AppKeyRepository;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AppKeyService implements AppKeyRepository
{
    /**
     * @var \App\Contracts\MassMailerKeyContract
     */
    protected MassMailerKeyContract $keyContract;

    /**
     * @var \Hashids\HashidsInterface
     */
    protected HashidsInterface $hashids;
    /**
     * @var \Illuminate\Contracts\Auth\Access\Gate
     */
    protected Gate $gate;

    /**
     * AppKeyService constructor.
     *
     * @param  \App\Contracts\MassMailerKeyContract  $keyContract
     * @param  \Hashids\HashidsInterface  $hashids
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    public function __construct(MassMailerKeyContract $keyContract, HashidsInterface $hashids, Gate $gate)
    {
        $this->keyContract = $keyContract;
        $this->hashids = $hashids;
        $this->gate = $gate;
    }

    /**
     * @throws \Spatie\Permission\Exceptions\UnauthorizedException
     * @throws \Throwable
     *
     * @param  int  $page
     * @param  int  $perPage
     * @param  \App\User  $user
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get(User $user, int $page, int $perPage): LengthAwarePaginator
    {
        if ($this->gate->check('getAppKeys', AppKey::class)) {
            $builder = AppKey::query();
        }

        if ($this->gate->check('getOwnAppKeys', AppKey::class)) {
            $builder = $user->keys()->paginate();
        }

        throw_if(!isset($builder), new UnauthorizedException(403));

        return $builder->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @throws ModelNotFoundException
     * @throws \Throwable
     * @throws \Spatie\Permission\Exceptions\UnauthorizedException
     *
     * @param  User  $user
     * @param  int  $appId
     *
     * @return array
     */
    public function store(int $appId, User $user): array
    {
        DB::beginTransaction();

        if ($this->gate->check('createAppKeys', AppKey::class)) {
            $application = Application::query()->findOrFail($appId);
        } elseif ($this->gate->check('createOwnAppKeys', AppKey::class)) {
            $application = $user->applications()->findOrFail($appId);
        } else {
            throw new UnauthorizedException(403);
        }

        return $this->keyContract->generateKey($application, $user);
    }


    /**
     * @throws \Throwable
     *
     * @param  int  $id
     *
     * @param  \App\User  $user
     *
     * @return bool
     */
    public function delete(User $user, int $id): bool
    {
        DB::beginTransaction();
        if ($user->hasPermissionTo('delete-app-keys')) {
            $appKey = AppKey::query()->where('id', '=', $id);
        } elseif ($user->hasPermissionTo('delete-own-app-keys')) {
            $appKey = $user->keys()->where('id', '=', $id);
        } else {
            throw new UnauthorizedException(403);
        }

        if ($appKey->delete() > 0) {
            DB::commit();
            return true;
        }

        DB::rollBack();
        return false;
    }
}
