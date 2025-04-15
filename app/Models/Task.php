<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = [
        'name',
        'task_code',
        'description',
        'due_date',
        'status',
        'priority',
        'project_id',
        'assigned_to',
        'created_by',
        'progress',
    ];

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function discussions()
    {
        return $this->morphMany(Discussion::class, 'discussionable');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
