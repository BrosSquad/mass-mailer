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
 * @property string $nonce
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AppKey whereNonce($value)
 */
class AppKey extends Model
{
    protected $fillable = [
        'key',
        'nonce',
        'user_id',
        'application_id'
    ];

    protected $hidden = [
        'key'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
