<?php

namespace App;

use Carbon\CarbonInterface;
use Hashids\HashidsInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package App
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $background_image
 * @property string $avatar
 * @property CarbonInterface $email_verified_at
 * @property CarbonInterface $created_at
 * @property CarbonInterface $last_login
 * @property CarbonInterface $updated_at
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRolesAndAbilities;

    /**
     * @var HashidsInterface
     */
    protected static $hashids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'avatar',
        'background_image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    public static function setHashids(HashidsInterface $hashids)
    {
        static::$hashids = $hashids;
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'user_id', 'id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'user_id', 'id');
    }

    public function refreshTokens(): HasMany
    {
        return $this->hasMany(RefreshToken::class, 'user_id', 'id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return static::$hashids->encodeHex($this->id);
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'role' => $this->getRoles()->first(),
        ];
    }

    public function keys(): HasMany
    {
        return $this->hasMany(AppKey::class, 'user_id', 'id');
    }
}
