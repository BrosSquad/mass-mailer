<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Subscription
 *
 * @package App
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Application[] $applications
 * @property-read int|null $applications_count
 * @method static Builder|Subscription newModelQuery()
 * @method static Builder|Subscription newQuery()
 * @method static Builder|Subscription query()
 * @method static Builder|Subscription whereCreatedAt($value)
 * @method static Builder|Subscription whereEmail($value)
 * @method static Builder|Subscription whereId($value)
 * @method static Builder|Subscription whereName($value)
 * @method static Builder|Subscription whereSurname($value)
 * @method static Builder|Subscription whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $surname
 * @property string $email
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 * @property int $id
 * @property string $name
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
