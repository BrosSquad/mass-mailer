<?php


namespace App\Services;


use App\User;
use App\Dto\CreateNewUser;
use Illuminate\Support\Str;
use App\Contracts\UserContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\PasswordReset;
use App\Dto\ChangePassword as ChangePasswordDto;
use App\Dto\CreateUser;
use App\Notifications\ChangePassword;
use App\Notifications\UserRegistered;
use Illuminate\Contracts\Hashing\Hasher;
use Throwable;
use Tymon\JWTAuth\JWTAuth;

class UserService implements UserContract
{
    private $hasher;
    private $auth;

    public function __construct(Hasher $hasher, JWTAuth $auth)
    {
        $this->hasher = $hasher;
        $this->auth = $auth;
    }

    /**
     * @param CreateUser $createUser
     * @return User
     * @throws Throwable
     */
    public function createUser(CreateUser $createUser): User
    {
        $randomPassword = Str::random(16);

        $user = new User([
            'name' => $createUser->name,
            'surname' => $createUser->surname,
            'email' => $createUser->email,
            'password' => $this->hasher->make($randomPassword)
        ]);

        $user->saveOrFail();

        $user->notify(new UserRegistered($user));
        $user->notify(new ChangePassword(ChangePasswordDto::fromUser($user), $this->auth));


        return $user;
    }

    public function deleteUser(int $id): bool
    {
        return DB::transaction(static function () use ($id) {
           return User::destroy($id) > 0;
        });
    }

    public function updateUserAccount()
    {
        // TODO: Implement updateUserAccount() method.
    }

    public function requestChangePassword(string $email)
    {
    }
}
