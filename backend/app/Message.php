<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 * @property integer $id
 * @property string $subject
 * @property string $from_email
 * @property string $from_name
 * @property string $reply_to
 * @property string $text
 * @property integer $application_id
 * @property integer $user_id
 * @property User $user
 * @property Application $application
 * @property Criteria[] $criteria
 * @property Notify[] $notified
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
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
        'mjml'
    ];

    public function criteria(): HasMany
    {
        return $this->hasMany(Criteria::class, 'message_id', 'id');
    }

    public function notified(): HasMany
    {
        return $this->hasMany(Notify::class, 'message_id', 'id');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
