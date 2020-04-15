<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Access
 *
 * @property-read \App\User|null $user
 * @method static Builder|Access newModelQuery()
 * @method static Builder|Access newQuery()
 * @method static Builder|Access query()
 * @method static Builder|Access whereCharset($value)
 * @method static Builder|Access whereCreatedAt($value)
 * @method static Builder|Access whereHttps($value)
 * @method static Builder|Access whereId($value)
 * @method static Builder|Access whereIpAccess($value)
 * @method static Builder|Access whereLocale($value)
 * @method static Builder|Access whereMethod($value)
 * @method static Builder|Access whereProtocolVersion($value)
 * @method static Builder|Access whereQueryString($value)
 * @method static Builder|Access whereRoute($value)
 * @method static Builder|Access whereUpdatedAt($value)
 * @method static Builder|Access whereUserAgent($value)
 * @method static Builder|Access whereUserId($value)
 * @mixin \Eloquent
 * @property int $id
 * @property int $https
 * @property string|null $user_agent
 * @property string|null $locale
 * @property string|null $charset
 * @property string|null $query_string
 * @property string|null $protocol_version
 * @property string|null $method
 * @property string|null $route
 * @property string|null $ipAccess
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
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

    /**
     * Get associated user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
