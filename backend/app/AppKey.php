<?php

namespace App;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class AppKey
 * @package App
 * @property integer $id
 * @property string $key
 * @property string $secret
 * @property integer $user_id
 * @property Application $application
 * @property User $User
 * @property integer $application_id
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class AppKey extends Model
{
    protected $fillable = [
        'key',
        'user_id'
    ];

    protected $hidden = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }
}
