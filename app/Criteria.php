<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Criteria extends Model
{
    protected $table = 'criteria';

    protected $fillable = [
        'field',
        'operator',
        'value'
    ];

    public function message(): BelongsTo {
        return $this->belongsTo(Message::class);
    }
}
