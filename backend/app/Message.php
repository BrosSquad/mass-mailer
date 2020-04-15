<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Message
 *
 * @property-read int|null $criteria_count
 * @property-read int|null $notified_count
 * @method static Builder|Message newModelQuery()
 * @method static Builder|Message newQuery()
 * @method static Builder|Message query()
 * @method static Builder|Message whereApplicationId($value)
 * @method static Builder|Message whereCreatedAt($value)
 * @method static Builder|Message whereFromEmail($value)
 * @method static Builder|Message whereFromName($value)
 * @method static Builder|Message whereId($value)
 * @method static Builder|Message whereMjml($value)
 * @method static Builder|Message whereParsed($value)
 * @method static Builder|Message whereReplyTo($value)
 * @method static Builder|Message whereSubject($value)
 * @method static Builder|Message whereText($value)
 * @method static Builder|Message whereUpdatedAt($value)
 * @method static Builder|Message whereUserId($value)
 * @mixin \Eloquent
 * @property int $id
 * @property string $subject
 * @property string $from_email
 * @property string $from_name
 * @property string $reply_to
 * @property string $text
 * @property int $application_id
 * @property int $user_id
 * @property User $user
 * @property Application $application
 * @property Criteria[] $criteria
 * @property Notify[] $notified
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 * @property int $mjml
 * @property string|null $parsed
 */
class Message extends Model
{
    protected $fillable = [
        'text',
        'from_email',
        'from_name',
        'reply_to',
        'subject',
        'application_id',
        'mjml',
        'parsed',
    ];

    public function criteria(): HasMany
    {
        return $this->hasMany(Criteria::class);
    }

    public function notified(): HasMany
    {
        return $this->hasMany(Notify::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
