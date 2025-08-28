<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $owner_id
 */
class Project extends Model
{
    protected $table = "task_projects";

    protected $fillable = ["name", "owner_id"];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function guests()
    {
        return $this->belongsToMany(User::class, table: 'task_project_shares');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function invites()
    {
        return $this->hasMany(ProjectInvite::class);
    }
}
