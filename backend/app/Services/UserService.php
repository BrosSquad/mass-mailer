<?php


namespace App\Services;


use App\User;
use App\Dto\CreateNewUser;
use Illuminate\Support\Str;
use App\Contracts\UserContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Hashing\Hasher;

class UserService implements UserContract
{
    private $hasher;
    
    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }
    
    /**
     * @param \App\Dto\CreateNewUser $createNewUser
     *
     * @throws \Throwable
     */
    public function createUser(CreateNewUser $createNewUser)
    {
        $user = new User([
            'name' => $createNewUser->name,
            'surname' => $createNewUser->surname,
            'email' => $createNewUser->email,
            'password' => Str::random(15)
        ]);
        
        $user->saveOrFail();
    }

    public function deleteUser(int $id)
    {
        return DB::transaction(static function () use ($id) {
           return User::destroy($id) > 0;
        });
    }

    public function updateUserAccount()
    {
        // TODO: Implement updateUserAccount() method.
    }
    
    public function changeUserPassword(string $email, string $newPassword)
    {
    
    }
}
