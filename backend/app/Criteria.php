<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Criteria
 * @package App
 * @property integer $id
 * @property string $field
 * @property string $operator
 * @property string $value
 * @property integer $message_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class Criteria extends Model
{
    protected $table = 'criteria';

    protected $fillable = [
        'field',
        'operator',
        'value'
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'message_id', 'id');
    }
}
