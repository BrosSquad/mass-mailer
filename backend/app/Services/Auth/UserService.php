<?php


namespace App\Services;


use App\Events\UserCreated;
use App\Contracts\UserContract;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use App\Dto\ChangePassword as ChangePasswordDto;
use App\Dto\CreateUser;
use App\Notifications\ChangePassword;
use App\Notifications\UserRegistered;
use App\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;
use Tymon\JWTAuth\Manager;

class UserService implements UserContract
{
    private Hasher $hasher;
    private Manager $manager;
    private UrlGenerator $urlGenerator;
    private EventDispatcher $eventDispatcher;

    public function __construct(Hasher $hasher, Manager $manager, UrlGenerator $urlGenerator, EventDispatcher $eventDispatcher)
    {
        $this->hasher = $hasher;
        $this->manager = $manager;
        $this->urlGenerator = $urlGenerator;
        $this->eventDispatcher = $eventDispatcher;
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
        $this->eventDispatcher->dispatch(new UserCreated($user));
        $user->notify(new UserRegistered($user));
        $user->notify(new ChangePassword(ChangePasswordDto::fromUser($user), $this->manager));


        return $user;
    }

    public function deleteUser(int $id): bool
    {
        return DB::transaction(static function () use ($id) {
            return User::destroy($id) > 0;
        });
    }

    public function updateUserAccount(User $user)
    {
        // TODO: Implement updateUserAccount() method.
    }


}
