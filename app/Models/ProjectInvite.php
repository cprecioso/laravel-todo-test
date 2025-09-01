<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $email
 * @property \Illuminate\Support\Carbon $expires_at
 * @property int $project_id
 */
class ProjectInvite extends Model
{
    use HasUlids;

    protected $table = "task_project_invites";

    protected $fillable = ["email", "expires_at", "project_id"];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
