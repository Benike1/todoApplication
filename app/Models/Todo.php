<?php

namespace App\Models;

use Database\Factories\TodoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'is_complete' => 'boolean',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'title', 'text', 'is_complete', 'expire_at', 'user_id'
    ];
    /**
     * @var string[]
     */
    protected $attributes = [
        'is_complete' => 0
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return TodoFactory
     */
    protected static function newFactory(): TodoFactory
    {
        return TodoFactory::new();
    }
}
