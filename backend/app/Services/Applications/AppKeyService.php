<?php


namespace App\Services\Applications;


use App\User;
use App\AppKey;
use App\Application;
use RuntimeException;
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
     * AppKeyService constructor.
     *
     * @param  \App\Contracts\MassMailerKeyContract  $keyContract
     */
    public function __construct(MassMailerKeyContract $keyContract)
    {
        $this->keyContract = $keyContract;
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
        $application = null;


        if ($user->hasPermissionTo('create-app-keys')) {
            $application = Application::query()->findOrFail($appId);
        } else {
            if ($user->hasPermissionTo('create-own-app-keys')) {
                $application = $user->applications()->findOrFail($appId);
            } else {
                throw new UnauthorizedException(403);
            }
        }

        /** @var Application $application */
        $appKey = $this->keyContract->generateKey($application->app_name);
        $key = new AppKey(
            [
                'key'     => $appKey['public'],
                'user_id' => $user->id,
            ]
        );


        if (!$application->appKeys()->save($key)) {
            DB::rollBack();
            throw new RuntimeException('Cannot save application key');
        }

        return $appKey['signedKey'];
    }


    /**
     * @throws \Exception
     * @throws \Spatie\Permission\Exceptions\UnauthorizedException
     *
     * @param  int  $id
     *
     * @return bool
     */
    public function deleteKey(User $user, int $id): bool
    {
        DB::beginTransaction();
        $appKey = null;
        if ($user->hasPermissionTo('delete-app-keys')) {
            $appKey = AppKey::query()->where('id', '=', $id);
        } else if($user->hasPermissionTo('delete-own-app-keys')) {
            $appKey = $user->keys()->where('id', '=', $id);
        } else {
            throw new UnauthorizedException(403);
        }

        if($appKey->delete() > 0) {
            DB::commit();
            return true;
        }

        DB::rollBack();
        return false;
    }
}
