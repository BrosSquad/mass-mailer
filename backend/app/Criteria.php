<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Criteria
 *
 * @package App
 * @property-read \App\Message $message
 * @method static Builder|Criteria newModelQuery()
 * @method static Builder|Criteria newQuery()
 * @method static Builder|Criteria query()
 * @mixin \Eloquent
 * @property string $field
 * @property string $operator
 * @property string $value
 * @property int $message_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 * @property int $id
 */
class Criteria extends Model
{
    protected $table = 'criteria';

    protected $fillable = [
        'field',
        'operator',
        'value',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
