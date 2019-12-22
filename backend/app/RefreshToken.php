<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class RefreshToken
 *
 * @package App
 * @property int $id
 * @property string $token
 * @property CarbonInterface $expires
 * @property int $user_id
 * @property User $user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|RefreshToken newModelQuery()
 * @method static Builder|RefreshToken newQuery()
 * @method static Builder|RefreshToken query()
 * @method static Builder|RefreshToken whereCreatedAt($value)
 * @method static Builder|RefreshToken whereExpires($value)
 * @method static Builder|RefreshToken whereId($value)
 * @method static Builder|RefreshToken whereToken($value)
 * @method static Builder|RefreshToken whereUpdatedAt($value)
 * @method static Builder|RefreshToken whereUserId($value)
 * @mixin \Eloquent
 */
class RefreshToken extends Model
{
    protected $fillable = [
        'token',
        'expires',
    ];

    protected $casts = [
        'expires' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
