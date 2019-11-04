<?php


namespace App\Services\Auth;


use App\Contracts\Auth\PasswordChangeContract;
use App\Notifications\RequestNewPassword;
use App\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Routing\UrlGenerator;
use Throwable;
use Tymon\JWTAuth\Manager;

class PasswordChangeService implements PasswordChangeContract
{
    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * @var Manager
     */
    private $manager;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    public function __construct(Manager $manager, Hasher $hasher, UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
        $this->manager = $manager;
        $this->hasher = $hasher;
    }

    /**
     * Changes user password
     * @param User $user
     * @param string $newPassword
     * @return bool
     * @throws Throwable
     */
    public function changePassword(User $user, string $newPassword): bool
    {
        $user->password = $this->hasher->make($newPassword);
        $user->saveOrFail();
        return true;
    }

    /**
     * @param string $email
     */
    public function requestChangePassword(string $email)
    {
        /** @var User $user */
        $user = User::query()
            ->where('email', '=', $email)
            ->firstOrFail();

        $payload = $this->manager
            ->getPayloadFactory()
            ->setTTL(10)
            ->claims(['sub' => $user->getJWTIdentifier(), 'email' => $user->email])
            ->make();

        $token = $this->manager->encode($payload)->get();

        $url = $this->urlGenerator->to(env('FRONTEND_URL') . '/change-password', [
            'token' => $token
        ]);

        $notification = (new RequestNewPassword($url))
            ->delay(now()->addSeconds(10))
            ->onQueue('reset-password');
        $user->notify($notification);

    }
}
