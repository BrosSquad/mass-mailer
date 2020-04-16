<?php

namespace App\Policies;

use App\User;
use App\Application;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function getOwnApplication(User $user): bool
    {
        return $user->hasPermissionTo('get-own-applications');
    }

    public function getApplications(User $user): bool
    {
        return $user->hasPermissionTo('get-applications');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-application');
    }

    public function update(User $user, Application $application): bool
    {
        if (
            $application->user_id === $user->id &&
            $user->hasPermissionTo('update-own-application')
        ) {
            return true;
        }

        if ($user->hasPermissionTo('update-application')) {
            return true;
        }

        return false;
    }

    public function delete(User $user, Application $application): bool
    {
        if (
            $application->user_id === $user->id &&
            $user->hasPermissionTo('delete-own-application')
        ) {
            return true;
        }

        if ($user->hasPermissionTo('delete-application')) {
            return true;
        }

        return false;
    }

}
