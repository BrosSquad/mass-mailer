<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Application
 *
 * @package App
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AppKey[] $appKeys
 * @property-read int|null $app_keys_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read int|null $notified_users_count
 * @property-read int|null $subscriptions_count
 * @method static Builder|Application newModelQuery()
 * @method static Builder|Application newQuery()
 * @method static Builder|Application query()
 * @method static Builder|Application whereAppName($value)
 * @method static Builder|Application whereCreatedAt($value)
 * @method static Builder|Application whereId($value)
 * @method static Builder|Application whereUpdatedAt($value)
 * @method static Builder|Application whereUserId($value)
 * @mixin \Eloquent
 * @property int $id
 * @property string $app_name
 * @property int $user_id
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
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function sendGridKey(): HasOne
    {
        return $this->hasOne(SendGridKey::class);
    }

    public function notifiedUsers(): HasMany
    {
        return $this->hasMany(Notify::class);
    }

    public function appKeys(): HasMany
    {
        return $this->hasMany(AppKey::class);
    }

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class, 'application_subscriptions');
    }
}
