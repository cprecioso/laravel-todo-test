<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $text
 * @property bool $is_completed
 */
class Task extends Model
{
    use HasUlids;

    protected $fillable = ["text", "is_completed", "user_id"];

    protected $attributes = [
        "is_completed" => false,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
