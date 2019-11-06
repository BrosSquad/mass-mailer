<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class RefreshToken
 * @package App
 * @property integer $id
 * @property string $token
 * @property CarbonInterface $expires
 * @property integer $user_id
 * @property User $user
 */
class RefreshToken extends Model
{
    protected $fillable = [
        'token',
        'expires'
    ];

    protected $casts = [
        'expires' => 'datetime'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
