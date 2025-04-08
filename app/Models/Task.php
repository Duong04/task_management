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
        'start_date',
        'end_date',
        'status',
        'priority',
        'project_id',
        'assigned_to'
    ];
}
