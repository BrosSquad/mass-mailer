<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->hasMany(Criteria::class);
    }

    public function notified(): HasMany {
        return $this->hasMany(Notify::class);
    }

    public function application(): BelongsTo {
        return $this->belongsTo(Application::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
