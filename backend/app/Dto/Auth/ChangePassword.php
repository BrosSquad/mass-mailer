<?php


namespace App\Dto;


use App\User;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class ChangePassword
 * @property string $email
 * @property integer $id
 * @package App\Dto
 */
class ChangePassword extends Base implements JWTSubject
{
    protected $email;
    protected $id;

    public static function fromUser(User $user): ChangePassword
    {
        return new static(['email' => $user->email, 'id' => $user->id]);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return ['email' => $this->email];
    }
}
