<?php


namespace App\Services;


use App\Contracts\LoginContract;
use App\Contracts\Signer\RsaSignerContract;
use App\Dto\Login;
use App\Exceptions\IncorrectPassword;
use App\Exceptions\RefreshTokens\InvalidRefreshToken;
use App\Exceptions\RefreshTokens\RefreshTokenExpired;
use App\Exceptions\RefreshTokens\RefreshTokenNotFound;
use App\RefreshToken;
use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;
use Tymon\JWTAuth\JWTAuth;

class LoginService implements LoginContract
{
    /**
     * @var JWTAuth
     */
    private $auth;

    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * @var RsaSignerContract
     */
    private $rsaSigner;

    /**
     * @var Config
     */
    private $config;


    public function __construct(JWTAuth $auth, Hasher $hasher, RsaSignerContract $rsaSigner, Config $config)
    {
        $this->auth = $auth;
        $this->hasher = $hasher;
        $this->rsaSigner = $rsaSigner;
        $this->config = $config;
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

            
        if (!$this->hasher->check($login->password, $user->password)) {
            throw new IncorrectPassword();
        }
            
        // TODO: Add check for email verification

        return DB::transaction(function () use ($user) {
            $refreshToken = $this->generateNewRefreshToken($rf, $user->id);

            $user->refreshTokens()->save($rf);
            return [
                'user' => new UserResource($user),
                'token' => [
                    'token' => $this->auth->fromSubject($user),
                    'refreshToken' => $refreshToken,
                    'authType' => 'Bearer',
                ]
            ];
        });
    }


    /**
     * @param string| null $refreshToken
     * @return array
     * @throws RefreshTokenExpired
     * @throws ModelNotFoundException
     * @throws RefreshTokenNotFound
     * @throws InvalidRefreshToken
     * @throws Throwable
     */
    public function refreshToken(?string $refreshToken): array
    {
        if ($refreshToken === null) {
            throw new RefreshTokenNotFound();
        }

        if(($data = $this->rsaSigner->verify($refreshToken)) === null)
        {
            throw new InvalidRefreshToken();
        }

        /** @var RefreshToken $rf */
        $rf = RefreshToken::query()
            ->with(['user'])
            ->where('token', '=', $data['data'])
            ->firstOrFail();

        if (now()->isAfter($rf->expires)) {
            throw new RefreshTokenExpired();
        }


        return [
            'token' => $this->auth->fromUser($rf->user),
            'refreshToken' => $this->generateNewRefreshToken($rf),
            'authType' => 'Bearer'
        ];
    }

    /**
     * @param RefreshToken $refreshToken
     * @param int $length
     * @param integer|null $userId
     * @return string
     * @throws Throwable
     */
    private function generateNewRefreshToken(RefreshToken& $refreshToken, $userId = null, int $length = 100): string
    {
        if(!isset($refreshToken)) {
            $refreshToken = new RefreshToken();
        }
        $data = Str::random($length);
        $refreshToken->token = $data;
        $refreshToken->expires = now()->addMinutes($this->config->get('jwt.refresh_ttl'));

        if (!$refreshToken->exists) {
            $refreshToken->user_id = $userId;
        }

        $refreshToken->saveOrFail();
        return $this->rsaSigner->sign($data);
    }
}
