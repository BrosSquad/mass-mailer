<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Notify
 *
 * @package App
 * @property int $id
 * @property string $email
 * @property bool $success
 * @property int $application_id
 * @property int $message_id
 * @property int $sendgrid_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
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
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }

    public function sendGridKey(): BelongsTo
    {
        return $this->belongsTo(SendGridKey::class, 'sendgrid_id', 'id');
    }
}
