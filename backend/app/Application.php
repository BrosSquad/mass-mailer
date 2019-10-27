<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 */
class Application extends Model
{
    protected $fillable = [
        'app_name',
        'db_name',
        'db_host',
        'db_driver',
        'db_port',
        'db_user',
        'db_password',
        'db_table',
        'email_field',
    ];

    protected $hidden = [
        'updated_at',
        'db_name',
        'db_port',
        'db_host',
        'db_driver',
        'db_user',
        'db_password',
        'db_table',
        'email_field',
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
}
