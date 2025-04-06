<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = [
        'name',
        'description',
    ];

    public function actions()
    {
        return $this->belongsToMany(Action::class, 'role_permissions', 'permission_id', 'action_id')->withPivot('role_id', 'permission_id','action_id');
    }

    public function permissionActions() {
        return $this->hasMany(PermissionAction::class, 'permission_id');
    }
}
