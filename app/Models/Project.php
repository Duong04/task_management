<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = [
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
        'created_by',
        'type',
        'manager_id',
        'department_id',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function discussions()
    {
        return $this->morphMany(Discussion::class, 'discussionable');
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function manager() {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function getProgressAttribute()
    {
        $totalTasks = $this->tasks()->count();

        if ($totalTasks === 0) {
            return 0;
        }

        $totalProgress = $this->tasks()->sum('progress');

        return round($totalProgress / $totalTasks, 2); 
    }
}
