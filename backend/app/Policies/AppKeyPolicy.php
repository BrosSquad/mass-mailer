<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppKeyPolicy
{
    use HandlesAuthorization;


    public function getAppKeys(User $user): bool
    {
        return $user->hasPermissionTo('get-app-keys');
    }

    public function getOwnAppKeys(User $user): bool
    {
        return $user->hasPermissionTo('get-own-app-keys');
    }

    public function createAppKeys(User $user): bool
    {
        return $user->hasPermissionTo('create-app-keys');
    }

    public function createOwnAppKeys(User $user): bool
    {
        return $user->hasPermissionTo('create-own-app-keys');
    }
}
