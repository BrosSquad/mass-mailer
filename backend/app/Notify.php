<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Notify
 *
 * @package App
 * @property-read \App\Application|null $application
 * @property-read \App\Message|null $message
 * @property-read \App\SendGridKey|null $sendGridKey
 * @method static Builder|Notify newModelQuery()
 * @method static Builder|Notify newQuery()
 * @method static Builder|Notify query()
 * @method static Builder|Notify whereApplicationId($value)
 * @method static Builder|Notify whereCreatedAt($value)
 * @method static Builder|Notify whereEmail($value)
 * @method static Builder|Notify whereId($value)
 * @method static Builder|Notify whereMessageId($value)
 * @method static Builder|Notify whereSendgridId($value)
 * @method static Builder|Notify whereSubscriptionId($value)
 * @method static Builder|Notify whereSuccess($value)
 * @method static Builder|Notify whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $id
 * @property string $email
 * @property bool $success
 * @property int $application_id
 * @property int $message_id
 * @property int $sendgrid_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 * @property int $subscription_id
 */
class Notify extends Model
{
    protected $table = 'notified';

    protected $fillable = [
        'email',
        'application_id',
        'message_id',
        'success',
        'subscription_id',
        'sendgrid_id',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function sendGridKey(): BelongsTo
    {
        return $this->belongsTo(SendGridKey::class, 'sendgrid_id', 'id');
    }
}
