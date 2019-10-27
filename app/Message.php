<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 * @property int id
 * @property string subject
 * @property string from_email
 * @property string from_name
 * @property string reply_to
 * @property string text
 * @property int application_id
 * @property int user_id
 * @property User user
 * @property Application application
 * @property Criteria[] criteria
 * @property Notify[] notified
 */
class Message extends Model
{
    protected $fillable = [
        'text',
        'from_email',
        'from_name',
        'reply_to',
        'subject',
        'application_id'
    ];

    public function criteria(): HasMany {
        return $this->hasMany(Criteria::class, 'message_id', 'id');
    }

    public function notified(): HasMany {
        return $this->hasMany(Notify::class, 'message_id', 'id');
    }

    public function application(): BelongsTo {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
