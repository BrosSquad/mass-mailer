<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Application
 *
 * @package App
 * @property integer $id
 * @property string $app_name
 * @property integer $user_id
 * @property AppKey $appKey
 * @property User $user
 * @property SendGridKey $sendGridKey
 * @property Notify[] $notifiedUsers
 * @property Subscription[] $subscriptions
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Application extends Model
{
    protected $fillable = [
        'app_name',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'application_id', 'id');
    }

    public function sendGridKey(): HasOne
    {
        return $this->hasOne(SendGridKey::class, 'application_id', 'id');
    }

    public function notifiedUsers(): HasMany
    {
        return $this->hasMany(Notify::class, 'application_id', 'id');
    }

    public function appKey(): HasOne {
        return $this->hasOne(AppKey::class, 'application_id', 'id');
    }

    public function subscriptions(): BelongsToMany {
        return $this->belongsToMany(Subscription::class, 'application_subscriptions');
    }
}
