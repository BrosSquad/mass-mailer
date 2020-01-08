<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AppKey
 *
 * @package App
 * @property-read \App\User $user
 * @method static Builder|AppKey newModelQuery()
 * @method static Builder|AppKey newQuery()
 * @method static Builder|AppKey query()
 * @method static Builder|AppKey whereApplicationId($value)
 * @method static Builder|AppKey whereCreatedAt($value)
 * @method static Builder|AppKey whereId($value)
 * @method static Builder|AppKey whereKey($value)
 * @method static Builder|AppKey whereUpdatedAt($value)
 * @method static Builder|AppKey whereUserId($value)
 * @mixin \Eloquent
 * @property int $id
 * @property string $key
 * @property string $secret
 * @property int $user_id
 * @property Application $application
 * @property User $User
 * @property int $application_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class AppKey extends Model
{
    protected $fillable = [
        'key',
        'user_id',
    ];

    protected $hidden = [
        'id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }
}
