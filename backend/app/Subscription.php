<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Subscription
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Subscription extends Model
{
    protected $table = 'subscriptions';


    protected $fillable = [
        'name',
        'surname',
        'email',
    ];

    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'application_subscriptions');
    }
}
