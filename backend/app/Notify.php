<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notify extends Model
{
    protected $table = 'notified';

    protected $fillable = [
        'email',
        'application_id',
        'message_id',
        'successful'
    ];

    public function message(): BelongsTo {
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }

    public function application(): BelongsTo {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }

    public function sendGridKey(): BelongsTo {
        return $this->belongsTo(SendGridKey::class, 'sendgrid_id', 'id');
    }
}
