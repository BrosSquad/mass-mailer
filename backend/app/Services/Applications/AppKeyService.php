<?php


namespace App\Services\Applications;


use App\User;
use App\AppKey;
use App\Application;
use Hashids\HashidsInterface;
use Illuminate\Support\Facades\DB;
use App\Contracts\MassMailerKeyContract;
use App\Contracts\Applications\AppKeyContract;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AppKeyService implements AppKeyContract
{
    protected MassMailerKeyContract $keyContract;
    /**
     * @var \Hashids\HashidsInterface
     */
    protected HashidsInterface $hashids;

    /**
     * AppKeyService constructor.
     *
     * @param  \App\Contracts\MassMailerKeyContract  $keyContract
     * @param  \Hashids\HashidsInterface  $hashids
     */
    public function __construct(MassMailerKeyContract $keyContract, HashidsInterface $hashids)
    {
        $this->keyContract = $keyContract;
        $this->hashids = $hashids;
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
    public function getAppKeys(User $user, int $page, int $perPage): LengthAwarePaginator
    {
        $builder = null;
        if ($user->hasPermissionTo('get-app-keys')) {
            $builder = AppKey::query();
        }

        if ($user->hasPermissionTo('get-own-app-keys')) {
            $builder = $user->keys()->paginate();
        }

        throw_if(!isset($builder), new UnauthorizedException(403));

        return $builder
            ->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @throws ModelNotFoundException
     * @throws \Throwable
     * @throws \Spatie\Permission\Exceptions\UnauthorizedException
     *
     * @param  User  $user
     * @param  int  $appId
     *
     * @return string
     */
    public function generateNewAppKey(int $appId, User $user): string
    {
        DB::beginTransaction();

        if ($user->hasPermissionTo('create-app-keys')) {
            $application = Application::query()->findOrFail($appId);
        } elseif ($user->hasPermissionTo('create-own-app-keys')) {
            $application = $user->applications()->findOrFail($appId);
        } else {
            throw new UnauthorizedException(403);
        }

        return  $this->keyContract->generateKey($application, $user);
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
    public function deleteKey(User $user, int $id): bool
    {
        DB::beginTransaction();
        $appKey = null;
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
