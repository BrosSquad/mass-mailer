<?php


namespace App\Services\Auth;

use App\User;
use Illuminate\Support\Str;
use App\Contracts\Auth\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\UrlGenerator;
use App\Notifications\UserRegistered;
use Illuminate\Contracts\Hashing\Hasher;

class UserService implements UserRepository
{
    protected Hasher $hasher;
    protected UrlGenerator $urlGenerator;

    public function __construct(Hasher $hasher, UrlGenerator $urlGenerator)
    {
        $this->hasher = $hasher;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @throws \Throwable
     *
     * @param  array  $createUser
     *
     * @return User
     */
    public function store(array $createUser): User
    {
        $randomPassword = Str::random(16);

        $user = new User(
            [
                'name'     => $createUser['name'],
                'surname'  => $createUser['surname'],
                'email'    => $createUser['email'],
                'password' => $this->hasher->make($randomPassword),
            ]
        );

        $user->saveOrFail();

        $user->assignRole($createUser['role']);

        $user->notify(new UserRegistered($user));


        return $user;
    }


    public function update(User $user, array $data): void
    {
    }


    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Throwable
     * @param  int  $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return DB::transaction(
            static function () use ($id) {
                $user = User::query()->findOrFail($id);

                if($user->delete()) {
                    return true;
                }

                return false;
            });
    }
}
