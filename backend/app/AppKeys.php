<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppKeys extends Model
{
    protected $fillable = [
        'key',
        'secret',
        'user_id'
    ];
    
    protected $hidden = ['id'];
    
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function application(): BelongsTo {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }
}
