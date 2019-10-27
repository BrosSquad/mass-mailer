<?php


namespace App\Services;


use App\Contracts\LoginContract;
use App\Dto\Login;
use App\Exceptions\IncorrectPassword;
use App\User;
use Illuminate\Contracts\Hashing\Hasher;
use Tymon\JWTAuth\JWTAuth;

class LoginService implements LoginContract
{
    private $auth;
    private $hasher;

    public function __construct(JWTAuth $auth, Hasher $hasher)
    {
        $this->auth = $auth;
        $this->hasher = $hasher;
    }

    /**
     * @param Login $login
     * @return array
     * @throws IncorrectPassword
     */
    public function login(Login $login): array
    {

        /** @var User $user */
        $user = User::query()
            ->where('email', '=', $login->email)
            ->firstOrFail();

        // TODO: Add check for email verification

        if(!$this->hasher->check($login->password, $user->password)) {
            throw new IncorrectPassword();
        }

        return ['user' => $user->getJWTCustomClaims(), 'token' => $this->auth->fromSubject($user)];
    }
}
