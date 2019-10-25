<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SendGridKey extends Model
{
    protected $fillable = [
        'key'
    ];

    protected $hidden =[
        'key',
        'updated_at'
    ];

    protected $table = 'sendgrid_keys';

    public function application(): BelongsTo {
        return $this->belongsTo(Application::class);
    }
}
