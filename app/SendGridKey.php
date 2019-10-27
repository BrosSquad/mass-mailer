<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SendGridKey extends Model
{
    protected $fillable = [
        'key',
        'number_of_messages'
    ];

    protected $hidden =[
        'id',
        'key',
        'created_at',
        'number_of_messages',
        'updated_at'
    ];

    protected $table = 'sendgrid_keys';

    public function application(): BelongsTo {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }

    public function messages(): HasMany {
        return $this->hasMany(Notify::class, 'sendgrid_id', 'id');
    }
}
