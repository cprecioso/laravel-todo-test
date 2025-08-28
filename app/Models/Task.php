<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $text
 * @property bool $is_completed
 * @property int $project_id
 */
class Task extends Model
{
    protected $fillable = ["text", "is_completed", "project_id"];

    protected $attributes = [
        "is_completed" => false,
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
