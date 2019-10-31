<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscription extends Model
{
    public function applications(): BelongsToMany {
        return $this->belongsToMany(Application::class, 'application_subscriptions');
    }
}
