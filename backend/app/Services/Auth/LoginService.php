<?php


namespace App\Services;


use App\Contracts\LoginContract;
use App\Dto\Login;
use App\Exceptions\IncorrectPassword;
use App\User;
use Illuminate\Contracts\Hashing\Hasher;
use Throwable;
use Tymon\JWTAuth\JWTAuth;

class LoginService implements LoginContract
{
    /**
     * @var JWTAuth
     */
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
     * @throws Throwable
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

        $user->last_login = now();
        $user->saveOrFail();
        $ttl = config('jwt.ttl');
        return [
            'user' => $user->getJWTCustomClaims(),
            'token' => [
                'token' => $this->auth->fromSubject($user),
                'authType' => 'Bearer',
                'expiresIn' => $ttl,
                'expiresAt' => now()->addMinutes($ttl)
            ]
        ];
    }
}
