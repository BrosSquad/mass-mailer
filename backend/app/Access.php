<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Access extends Model
{
    protected $fillable = [
        'https',
        'user_agent',
        'locale',
        'charset',
        'query_string',
        'protocol_version',
        'method',
        'route',
        'sipAccess',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
