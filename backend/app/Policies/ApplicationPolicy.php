<?php

namespace App\Policies;

use App\User;
use App\Application;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-application');
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
