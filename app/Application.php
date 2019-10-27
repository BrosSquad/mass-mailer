<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    protected $fillable = [
        'app_name',
        'db_name',
        'db_host',
        'db_driver',
        'db_user',
        'db_password',
        'db_table',
        'email_field',
    ];

    protected $hidden = [
        'updated_at',
        'db_name',
        'db_host',
        'db_driver',
        'db_user',
        'db_password',
        'db_table',
        'email_field',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany {
        return $this->hasMany(Message::class);
    }

    public function  sendGridKey(): HasOne {
        return $this->hasOne(SendGridKey::class);
    }

    public function notifiedUsers(): HasMany {
        return $this->hasMany(Notify::class);
    }
}
